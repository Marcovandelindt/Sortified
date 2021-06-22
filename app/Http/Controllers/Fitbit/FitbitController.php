<?php

namespace App\Http\Controllers\Fitbit;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Services\Fitbit\FitbitService;

class FitbitController extends Controller
{
    protected $fitbitService;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->fitbitService = new FitbitService;
    }

    /**
     * Index action
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function index(Request $request)
    {
        if (!empty($request->code)) {
            $provider = $this->fitbitService->createProvider();

            try {
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $request->code
                ]);

                $user = User::findOrFail(Auth::user()->id);

                $accessTokenStored  = false;
                $refreshTokenStored = false;

                # Store access token if needed
                if (empty($user->fitbit_access_token) || $user->fitbit_access_token !== $accessToken->getToken()) {
                    $user->fitbit_access_token = $accessToken->getToken();
                    $accessTokenStored = true;
                }

                # Store refresh token if needed
                if (empty($user->fitbit_refresh_token) || $user->fitbit_refresh_token !== $accessToken->getRefreshToken()) {
                    $user->fitbit_refresh_token = $accessToken->getRefreshToken();
                    $refreshTokenStored = true;
                }

                if ($accessTokenStored == true || $refreshTokenStored == true) {
                    $user->save();
                }

            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                dd($e->getMessage());
            }
        }

        return redirect()->route('food.drinks');
    }

    /**
     * Update walking data
     *
     */
    public function updateWalkingData()
    {
        $this->fitbitService->getLifetimeSteps();

        return redirect()->route('health.statistics');
    }

    /**
     * Update food
     */
    public function updateFood()
    {
        $this->fitbitService->getMeals();

        return redirect()->route('food.drinks');
    }

    /**
     * Update water
     */
    public function updateWater()
    {
        $this->fitbitService->getWaterIntake();

        return redirect()->route('food.drinks');
    }
}
