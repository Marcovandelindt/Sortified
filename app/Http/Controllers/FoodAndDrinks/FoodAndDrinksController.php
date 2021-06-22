<?php

namespace App\Http\Controllers\FoodAndDrinks;

use App\Http\Controllers\Controller;
use App\Models\FoodAndDrinks\FoodLog;
use App\Models\FoodAndDrinks\WaterLog;
use Illuminate\Contracts\View\View;

class FoodAndDrinksController extends Controller
{
    /**
     * Index action
     *
     * @return View
     */
    public function index()
    {
        $foodLogs  = FoodLog::where('log_date', date('Y-m-d'))->get();
        $waterLogs = WaterLog::where('date', date('Y-m-d'))->get();

        $data = [
            'foodLogs'  => $foodLogs,
            'waterLogs' => $waterLogs,
        ];

        return view('foodAndDrinks.index')->with($data);
    }
}
