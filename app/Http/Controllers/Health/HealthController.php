<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use App\Models\Health\DailyStep;
use Illuminate\Contracts\View\View;
use App\Services\Fitbit\FitbitService;

class HealthController extends Controller
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
     * Index action
     *
     * @return View
     */
    public function index(): View
    {
        $dailySteps = DailyStep::where('date', date('Y-m-d'))->first();

        $data = [
            'dailySteps' => $dailySteps,
        ];

        return view('health.index')->with($data);
    }
}
