<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class MusicController extends Controller
{
    /**
     * Index action
     *
     * @return View
     */
    public function index()
    {
        return view('music.index');
    }
}
