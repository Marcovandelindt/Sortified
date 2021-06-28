<?php

namespace App\Services\Music;

use Illuminate\Support\Facades\DB;

use App\Models\Music\PlayedTrack;
use App\Models\Music\Track;

class PlayedTrackService
{
    /**
     * Save a played track
     *
     * @param object $data
     * @param \App\Models\Music\Track $track
     *
     * @return void
     */
    public function savePlayedTrack($data, Track $track): void
    {
        $playedTrack = new PlayedTrack;

        $playedTrack->track_id    = $track->id;
        $playedTrack->played_from = (!empty($data->context->type) ? $data->context->type : '');
        $playedTrack->played_at   = strtotime($data->played_at);
        $playedTrack->played_date = date('Y-m-d', strtotime($data->played_at));
        $playedTrack->time        = date('H:i', strtotime('+2 hours', strtotime($data->played_at)));

        $playedTrack->save();
    }

    /**
     * Calculate the total listning time
     *
     * @param array $playedTracks
     * @param bool  $formatted
     *
     * @return $string
     */
    public function calculateListeningTime($playedTracks, $formatted = false)
    {
        $time = 0;

        if (!empty($playedTracks)) {
            foreach ($playedTracks as $playedTrack) {
                $time = $time + $playedTrack->track->duration_ms;
            }
        }

        $seconds = ($time / 1000);
        $hours   = 0;
        $minutes = 0;

        if ($seconds >= 3600) {
            $hours   = floor($seconds / 3600);
            $seconds = $seconds % 3600;
        }

        if ($seconds >= 60) {
            $minutes = floor($seconds / 60);
        }

        if ($formatted) {
            return $hours . ' hours ' . ($minutes != 0 ? 'and ' . $minutes . ' minutes' : '');
        }

        return $hours . ($minutes != 0 ? ':' . $minutes : '');
    }
}
