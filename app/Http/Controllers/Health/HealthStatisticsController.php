<?php

namespace App\Http\Controllers\Health;

use App\Models\FoodAndDrinks\WaterLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Services\FoodAndDrinks\WaterLogService;

class HealthStatisticsController extends Controller
{
    /**
     * Index action
     *
     * @return View
     */
    public function index(Request $request): View
    {
        if (!empty($request->type)) {
            if ($request->type == 'lifetime') {

                # Get data for lifetime statistics
                $waterAmount = WaterLogService::getLifetimeAmount();
                $firstWaterLog = WaterLog::all()->first();

            }
        }

        $data = [
            'waterAmount' => $waterAmount,
            'firstWaterLog' => $firstWaterLog,
        ];

        return view('health.statistics')->with($data);
    }
}
