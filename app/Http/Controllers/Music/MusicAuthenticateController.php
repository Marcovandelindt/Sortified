<?php

namespace App\Http\Controllers\Music;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session as SpotifySession;

use App\Http\Controllers\Controller;
use App\Services\Music\MusicService;


class MusicAuthenticateController extends Controller
{
    protected $musicService;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->musicService = new MusicService;
    }

    /**
     * Index action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        $session = new SpotifySession(
            Auth::user()->spotify_client_id,
            Auth::user()->spotify_client_secret,
            env('SPOTIFY_REDIRECT_URI'),
        );

        return redirect($session->getAuthorizeUrl($this->musicService->getAllScopes()));
    }
}
