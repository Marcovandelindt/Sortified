<?php

namespace App\Services\FoodAndDrinks;

use App\Models\FoodAndDrinks\WaterLog;

class WaterLogService
{
    /**
     * Get a lifetime amount of all water drank
     *
     */
    public static function getLifetimeAmount()
    {
        $waterLogs = WaterLog::all();

        $amount = 0;

        foreach ($waterLogs as $waterLog) {
            $amount += $waterLog->amount;
        }

        return $amount;
    }

}
