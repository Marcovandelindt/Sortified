<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HealthStatisticsController extends Controller
{
    /**
     * Index action
     *
     * @return View
     */
    public function index(): View
    {
        return view('health.statistics');
    }
}