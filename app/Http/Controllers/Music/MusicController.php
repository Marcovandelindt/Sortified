<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;
use App\Repositories\Music\AlbumRepositoryInterface;
use App\Repositories\Music\PlayedTrackRepositoryInterface;
use App\Repositories\Music\ArtistRepositoryInterface;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    private $playedTrackRepository;
    private $albumRepository;
    private $artistRepository;

    /**
     * Constructor
     *
     */
    public function __construct(PlayedTrackRepositoryInterface $playedTrackRepository, AlbumRepositoryInterface $albumRepository, ArtistRepositoryInterface $artistRepository)
    {
        $this->middleware('auth');

        $this->playedTrackRepository = $playedTrackRepository;
        $this->albumRepository       = $albumRepository;
        $this->artistRepository      = $artistRepository;
    }

    /**
     * Show the index view
     *
     */
    public function index()
    {
        return view('music.index', [
            'title'             => 'Music',
            'page'              => 'music',
            'tracks'            => $this->playedTrackRepository->today(50),
            'totalPlayedTracks' => count($this->playedTrackRepository->today()),
            'albums'            => $this->albumRepository->today(),
            'artists'           => $this->artistRepository->today(),
            'listeningTime'     => $this->playedTrackRepository->calculateListeningTime('daily'),
        ]);
    }
}

