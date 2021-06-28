<?php

namespace App\Services\Music;

use App\Models\Music\Track;

use SpotifyWebAPI\SpotifyWebAPI;

class TrackService
{
    /**
     * Save and return a newly created track
     *
     * @param object                       $data
     * @param \SpotifyWebAPI\SpotifyWebAPI $api
     *
     * @return \App\Models\Music\Track
     */
    public function createNewTrack($data, $api): Track
    {
        $trackData = $api->getTrack($data->track->id);

        if (!empty($trackData)) {
            $track = new Track;

            $track->spotify_id   = $trackData->id;
            $track->name         = $trackData->name;
            $track->duration_ms  = $trackData->duration_ms;
            $track->disc_number  = $trackData->disc_number;
            $track->popularity   = $trackData->popularity;
            $track->track_number = $trackData->track_number;

            $track->save();

            return $track;
        }
    }
}
