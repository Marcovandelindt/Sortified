<?php

namespace App\Services\Fitbit;

use App\Models\Health\CityDistance;
use App\Models\FoodAndDrinks\Drink;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodAndDrinks\FoodLog;
use App\Models\FoodAndDrinks\DrinkLog;
use App\Models\FoodAndDrinks\WaterLog;
use djchen\OAuth2\Client\Provider\Fitbit;
use App\Models\Health\DailyStep;

class FitbitService
{
    protected $fitbitProvider;

    const WATER_LOG_ENDPOINT = '/1/user/-/foods/log/water/date/';
    const FOOD_LOG_ENDPOINT  = '/1/user/-/foods/log/date/';
    const ACTIVITY_ENDPOINT  = '/1/user/-/activities';
    const STEPS_ENDPOINT     = '/1/user/-/activities/tracker/steps/date';


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
    /**
     * Generate GET request
     *
     * @param string $endpoint
     * @param $user
     */
    public function generateGetRequest($endpoint, $user = null)
    {
        if (empty($user)) {
            $user = Auth::user();
        }

        $fitBitProvider = $this->createProvider();

        $request = $fitBitProvider->getAuthenticatedRequest(
            Fitbit::METHOD_GET,
            Fitbit::BASE_FITBIT_API_URL . $endpoint,
            $user->fitbit_access_token,
            [
                'headers' => [
                    Fitbit::HEADER_ACCEPT_LANG => 'en_US',
                    [
                        Fitbit::HEADER_ACCEPT_LOCALE => 'en_US',
                    ]
                ]
            ]
        );

        $response = $fitBitProvider->getParsedResponse($request);

        if ($response) {
            return $response;
        }

        return false;
    }

    /**
     * Get water intake
     *
     * @param string $date
     */
    public function getWaterIntake($date = null)
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }

        $url = self::WATER_LOG_ENDPOINT . $date . '.json';

        $request = $this->generateGetRequest($url);

        if (!empty($request)) {
            foreach ($request['water'] as $waterLog) {
                if (!WaterLog::where('log_id', $waterLog['logId'])->first()) {
                    $log = new WaterLog();

                    # Convert oz to ml
                    $log->amount = $waterLog['amount'] / 0.033814;
                    $log->log_id = $waterLog['logId'];
                    $log->date   = date('Y-m-d');

                    $log->save();
                }
            }
        }
    }

    /**
     * Get Meals
     *
     * @param string $date
     */
    public function getMeals($date = null)
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }

        $url = self::FOOD_LOG_ENDPOINT . $date . '.json';

        $request = $this->generateGetRequest($url);

        if (!empty($request)) {
            foreach ($request['foods'] as $foodLog) {
                if (!FoodLog::where('log_id', $foodLog['logId'])->first()) {
                    $log = new FoodLog();
                } else {
                    $log = FoodLog::where('log_id', $foodLog['logId'])->first();
                }

                $log->log_id       = $foodLog['logId'];
                $log->log_date     = $foodLog['logDate'];
                $log->brand        = $foodLog['loggedFood']['brand'];
                $log->amount       = $foodLog['loggedFood']['amount'];
                $log->calories     = $foodLog['loggedFood']['calories'];
                $log->food_id      = $foodLog['loggedFood']['foodId'];
                $log->meal_type_id = $foodLog['loggedFood']['mealTypeId'];
                $log->name         = $foodLog['loggedFood']['name'];
                $log->carbs        = $foodLog['nutritionalValues']['carbs'];
                $log->fat          = $foodLog['nutritionalValues']['fat'];
                $log->fiber        = $foodLog['nutritionalValues']['fiber'];
                $log->protein      = $foodLog['nutritionalValues']['protein'];
                $log->sodium       = $foodLog['nutritionalValues']['protein'];

                $log->save();

            }
        }
    }

    /**
     * Get lifetime steps
     *
     */
    public function getLifetimeSteps()
    {
        $url = self::ACTIVITY_ENDPOINT . '.json';

        $request = $this->generateGetRequest($url);

        if (!empty($request)) {
            $user = Auth::user();
            $user->total_steps = $request['lifetime']['total']['steps'];
            $user->total_distance_walked = $request['lifetime']['total']['distance'];

            $user->save();
        }
    }

    /**
     * Get daily steps
     */
    public function getDailySteps($date = null)
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }

        $url = self::ACTIVITY_ENDPOINT . '/date/' . $date . '.json';

        $request = $this->generateGetRequest($url);

        if (!empty($request)) {
            if (!DailyStep::where('date', $date)->first()) {
                $dailyStep          = new DailyStep();
                $dailyStep->user_id = Auth::user()->id;
                $dailyStep->steps   = $request['summary']['steps'];
                $dailyStep->date    = $date;

                $dailyStep->save();
            }
        }
    }
}
