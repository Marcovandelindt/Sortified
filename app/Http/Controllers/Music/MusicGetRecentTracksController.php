<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

use App\Models\Music\Track;
use App\Models\Music\PlayedTrack;
use App\Models\Music\Artist;
use App\Models\Music\Genre;
use App\Models\Music\Album;

use App\Services\Music\TrackService;
use App\Services\Music\PlayedTrackService;
use App\Services\Music\ArtistService;
use App\Services\Music\GenreService;
use App\Services\Music\AlbumService;

class MusicGetRecentTracksController extends Controller
{
    protected $trackService;
    protected $playedTrackService;
    protected $artistService;
    protected $genreService;
    protected $albumService;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->trackService       = new TrackService;
        $this->playedTrackService = new PlayedTrackService;
        $this->artistService      = new ArtistService;
        $this->genreService       = new GenreService;
        $this->albumService       = new AlbumService;
    }

    /**
     * Add the recent tracks
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(): RedirectResponse
    {
        $api = new SpotifyWebAPI();
        $api->setAccessToken(Auth::user()->spotify_access_token);

        $tracks = $api->getMyRecentTracks(['limit' => 50]);

        foreach ($tracks->items as $trackData) {

            # Save the track
            if (!Track::where('spotify_id', $trackData->track->id)->first()) {
                $track = $this->trackService->createNewTrack($trackData, $api);
            } else {
                $track = Track::where('spotify_id', $trackData->track->id)->first();
            }

            # Save the played track
            $timestamp = strtotime($trackData->played_at);
            if (!PlayedTrack::where('track_id', $track->id)->where('played_at', $timestamp)->first()) {
                $this->playedTrackService->savePlayedTrack($trackData, $track);


                # Save the artists
                foreach ($trackData->track->artists as $artistData) {
                    if (!Artist::where('spotify_id', $artistData->id)->first()) {
                        $artist = $this->artistService->createArtist($artistData, $api);
                    } else {
                        $artist = Artist::where('spotify_id', $artistData->id)->first();
                    }

                    $this->artistService->updatePlayCount($artist);

                    if (!$artist->hasTrack($track->id)) {
                        $artist->tracks()->attach($track->id);
                    }

                    # Save the genre
                    foreach ($api->getArtist($artist->spotify_id)->genres as $genre) {
                        $systemName = $this->genreService->createSystemName($genre);
                        if (!Genre::where('system_name', $systemName)->first()) {
                            $this->genreService->createGenre($genre);
                        }
                    }
                }

                # Save the album
                if (!Album::where('spotify_id', $trackData->track->album->id)->first()) {
                    $album = $this->albumService->createNewAlbum($trackData->track->album, $api);
                } else {
                    $album = Album::where('spotify_id', $trackData->track->album->id)->first();
                }

                if (!$track->album_id) {
                    $track->album_id = $album->id;
                    $track->save();
                }

                # Save relation between artist(s) and album
                foreach ($trackData->track->album->artists as $albumArtist) {
                    $existingArtist = Artist::where('spotify_id', $albumArtist->id)->first();
                    if (!empty($existingArtist) && !$existingArtist->hasAlbum($album->id)) {
                        $existingArtist->albums()->attach($album->id);
                    }
                }
            }
        }

        return redirect()->route('music');
    }
}
