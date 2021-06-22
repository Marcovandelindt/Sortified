<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    /**
     * Index action
     *
     * @returns View
     */
    public function index()
    {
        return view('calendar.index');
    }
}
