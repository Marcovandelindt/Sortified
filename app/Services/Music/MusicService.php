<?php

namespace App\Services\Music;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Music\PlayedTrack;
use App\Models\Music\Artist;
use App\Models\Music\Album;

class MusicService
{
    /**
     * Define the scopes for authorization
     */
    const SCOPES = [
        'ugc-image-upload',
        'user-read-recently-played',
        'user-top-read',
        'user-read-playback-position',
        'user-read-playback-state',
        'user-modify-playback-state',
        'user-read-currently-playing',
        'app-remote-control',
        'streaming',
        'playlist-modify-public',
        'playlist-modify-private',
        'playlist-read-private',
        'playlist-read-collaborative',
        'user-follow-modify',
        'user-follow-read',
        'user-library-modify',
        'user-library-read',
        'user-read-email',
        'user-read-private',
    ];

    /**
     * Get all the scopes
     */
    public function getAllScopes()
    {
        return [
            'scope' => self::SCOPES,
        ];
    }

    /**
     * Get the start date for generating a report
     *
     * @param string $timeFrame
     *
     */
    public function getStartDateForReport($timeFrame)
    {
        $currentDate = Carbon::now();

        switch ($timeFrame) {
            case 'weekly':
                $previousWeek = $currentDate->subDays(7);
                $startDay     = $previousWeek->startOfWeek()->format('Y-m-d');
                break;
        }

        return $startDay;
    }

    /**
     * Get the end date for generating a report
     *
     * @param string $timeFrame
     */
    public function getEndDateForReport($timeFrame)
    {
        $currentDate = Carbon::now();

        switch($timeFrame) {
            case 'weekly':
                $previousWeek = $currentDate->subDays(7);
                $endDay       = $previousWeek->endOfWeek()->format('Y-m-d');
                break;
        }

        return $endDay;
    }

    /**
     * Generate the listening report
     *
     * @param string $startDate
     * @param string $endDate
     *
     * @return array
     */
    public function generateListeningReport($startDate, $endDate): array
    {
        # Get the top tracks based on given dates
        $topPlayedTracks = PlayedTrack::select('*', DB::raw('count(*) AS total'))
            ->join('tracks', 'played_tracks.track_id', '=', 'tracks.id')
            ->groupBy('track_id')
            ->orderByRaw('COUNT(*) DESC')
            ->orderByRaw('tracks.name DESC')
            ->whereBetween('played_date', [$startDate, $endDate])
            ->limit(10)
            ->get();

        $topTracks = [];

        foreach ($topPlayedTracks as $topPlayedTrack) {
            $track        = $topPlayedTrack->track;
            $track->total = $topPlayedTrack->total;
            $topTracks[]  = $track;
        }

        # Get the top artists based on the given dates
        $topPlayedArtists = Artist::select('artists.*', DB::raw('COUNT(*) as total'))
            ->join('artist_track', 'artists.id', '=', 'artist_track.artist_id')
            ->join('played_tracks', 'artist_track.track_id', '=', 'played_tracks.track_id')
            ->groupBy('artists.id')
            ->orderByRaw('COUNT(*) DESC')
            ->orderByRaw('artists.name')
            ->whereBetween('played_tracks.played_date', [$startDate, $endDate])
            ->limit(10)
            ->get();

        # Get the top albums based on the given dates
        $topPlayedAlbums = Album::select('albums.*', DB::raw('COUNT(*) as total'))
            ->join('tracks', 'albums.id', '=', 'tracks.album_id')
            ->join('played_tracks', 'tracks.id', '=', 'played_tracks.track_id')
            ->groupBy('albums.id')
            ->orderByRaw('COUNT(*) DESC')
            ->orderByRaw('albums.name DESC')
            ->whereBetween('played_tracks.played_date', [$startDate, $endDate])
            ->limit(10)
            ->get();

        return [
            'topTracks'  => $topTracks,
            'topArtists' => $topPlayedArtists,
            'topAlbums'  => $topPlayedAlbums,
        ];
    }
}
