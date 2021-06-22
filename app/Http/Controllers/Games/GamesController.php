<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class GamesController extends Controller
{
    /**
     * Index action
     *
     * @returns View
     */
    public function index(): View
    {
        return view('games.index');
    }
}
