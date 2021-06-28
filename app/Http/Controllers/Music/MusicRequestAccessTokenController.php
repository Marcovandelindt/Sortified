<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use SpotifyWebAPI\Session as SpotifySession;

use App\Models\User;

class MusicRequestAccessTokenController extends Controller
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store the access token and refresh token
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::user()->id);

        $session = new SpotifySession(
            $user->spotify_client_id,
            $user->spotify_client_secret,
            env('SPOTIFY_REDIRECT_URI')
        );

        $session->requestAccessToken($request->code);

        if ($session->getAccessToken() && $session->getRefreshToken()) {
            $user->spotify_access_token  = $session->getAccessToken();
            $user->spotify_refresh_token = $session->getRefreshToken();

            $user->save();
        }

        return redirect()->route('music');
    }
}
