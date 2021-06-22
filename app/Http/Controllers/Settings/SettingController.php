<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Index action
     *
     * @returns View
     */
    public function index()
    {
        return view('settings.index');
    }
}
