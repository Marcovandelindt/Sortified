<?php

namespace App\Services\Music;

use App\Models\Music\Artist;

class ArtistService
{
    /**
     * Create a new artist
     *
     * @param object                       $data
     * @param \SpotifyWebAPI\SpotifyWebAPI $api
     *
     * @return App\Models\Music\Artist $artist
     */
    public function createArtist($data, $api)
    {
        $artistData = $api->getArtist($data->id);

        if (!empty($artistData)) {
            $artist = new Artist;

            $artist->spotify_id = $artistData->id;
            $artist->name       = $artistData->name;
            $artist->image      = !empty($artistData->images) ? $artistData->images[0]->url : '';
            $artist->popularity = $artistData->popularity;
            $artist->followers  = $artistData->followers->total;

            $artist->save();

            return $artist;
        }
    }

    /**
     * Update the playcount of an artist
     *
     * @param \App\Models\Artist $artist
     *
     * @return void
     */
    public function updatePlayCount(Artist $artist): void
    {
        $artist->play_count = $artist->play_count + 1;

        $artist->save();
    }
}
