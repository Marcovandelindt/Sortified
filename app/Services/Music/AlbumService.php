<?php

namespace App\Services\Music;

use App\Models\Music\Album;

class AlbumService
{
    /**
     * Create a new album
     *
     * @param object                       $data
     * @param \SpotifyWebAPI\SpotifyWebAPI $api
     *
     * @return \App\Models\Music\Album
     */
    public function createNewAlbum($data, $api): Album
    {
        $albumData = $api->getAlbum($data->id);

        if (!empty($albumData)) {
            $album = new Album;

            $album->spotify_id   = $albumData->id;
            $album->name         = $albumData->name;
            $album->image        = !empty($albumData->images) ? $albumData->images[0]->url : '';
            $album->release_date = $albumData->release_date;
            $album->label        = $albumData->label;
            $album->total_tracks = $albumData->total_tracks;
            $album->popularity   = $albumData->popularity;
            $album->type         = $albumData->album_type;

            $album->save();

            return $album;
        }
    }
}
