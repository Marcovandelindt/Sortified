<?php

namespace App\Repositories\Music;

use Illuminate\Support\Collection;

use App\Repositories\Music\Eloquent\AlbumRepository;

use App\Models\Music\PlayedTrack;

interface AlbumRepositoryInterface
{
    public function today();

    public function all();

    public function getTopAlbums($limit);
}
