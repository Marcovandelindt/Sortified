<?php

namespace App\Http\Controllers\Fitbit;

use App\Http\Controllers\Controller;
use App\Services\Fitbit\FitbitService;
use Illuminate\Http\RedirectResponse;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class FitbitRequestAccessTokenController extends Controller
{
    protected $fitbitService;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->fitbitService = new FitbitService();
    }

    /**
     * Request the access token
     *
     * @return RedirectResponse
     */
    public function request()
    {
        $fitbitProvider = $this->fitbitService->createProvider();

        $authorizationUrl = $fitbitProvider->getAuthorizationUrl();

        session('oauth2state', $fitbitProvider->getState());

        return redirect($authorizationUrl);
    }
}
