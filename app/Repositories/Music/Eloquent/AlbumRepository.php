<?php

namespace App\Repositories\Music\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Models\Music\Album;
use App\Models\Music\PlayedTrack;
use App\Repositories\Music\AlbumRepositoryInterface;
use App\Repositories\Music\PlayedTrackRepositoryInterface;

class AlbumRepository implements AlbumRepositoryInterface
{
    /**
     * Get all played albums today
     */
    public function today()
    {
        $playedTracks = PlayedTrack::where('played_date', date('Y-m-d'))->get();

        $albums = [];
        foreach ($playedTracks as $playedTrack) {
            if (!empty($playedTrack->track->album)) {
                $albums[$playedTrack->track->album->id] = $playedTrack->track->album;
            }
        }

        return $albums;
    }

    /**
     * Get all played albums
     */
    public function all()
    {
        return Album::all();
    }

    /**
     * Get the top albums
     *
     * @param int $limit
     */
    public function getTopAlbums($limit)
    {
        return Album::select('albums.*', DB::raw('count(*) as album_count'))
            ->join('tracks', 'albums.id', '=', 'tracks.album_id')
            ->join('played_tracks', 'tracks.id', '=', 'played_tracks.track_id')
            ->groupBy('albums.id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit($limit)
            ->get();
    }
}
