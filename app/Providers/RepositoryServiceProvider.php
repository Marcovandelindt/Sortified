<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Music\AlbumRepositoryInterface;
use App\Repositories\Music\ArtistRepositoryInterface;
use App\Repositories\Music\Eloquent\AlbumRepository;
use App\Repositories\Music\Eloquent\ArtistRepository;
use App\Repositories\Music\Eloquent\PlayedTrackRepository;
use App\Repositories\Music\PlayedTrackRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlayedTrackRepositoryInterface::class, PlayedTrackRepository::class);
        $this->app->bind(AlbumRepositoryInterface::class, AlbumRepository::class);
        $this->app->bind(ArtistRepositoryInterface::class, ArtistRepository::class);
        $this->app->bind(JournalRepositoryInterface::class, JournalRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
