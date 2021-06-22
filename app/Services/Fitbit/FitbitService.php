<?php

namespace App\Services\Fitbit;

use Illuminate\Support\Facades\Auth;
use djchen\OAuth2\Client\Provider\Fitbit;

class FitbitService
{
    protected $fitbitProvider;

    /**
     * Create new Fitbit Provider
     *
     * @return Fitbit
     */
    public function createProvider($user = null)
    {
        if (empty($user)) {
            $user = Auth::user();
        }

        $this->fitbitProvider = new Fitbit(
            [
                'clientId'     => $user->fitbit_client_id,
                'clientSecret' => $user->fitbit_client_secret,
                'redirectUri'  => env('FIBIT_REDIRECT_URI'),
            ]
        );

        return $this->fitbitProvider;
    }
}
