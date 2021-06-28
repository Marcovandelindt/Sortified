<?php

namespace App\Repositories\Music;

use Illuminate\Support\Collection;

use App\Repositories\Music\Eloquent\ArtistRepository;

use App\Models\Music\PlayedTrack;

interface ArtistRepositoryInterface
{
    public function today();

    public function all();

    public function getTopArtists($limit);

    public function getUniquePlayedArtists($timeFrame, $paginatedResults = null);
}
