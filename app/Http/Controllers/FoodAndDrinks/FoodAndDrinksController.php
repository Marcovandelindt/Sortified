<?php

namespace App\Http\Controllers\FoodAndDrinks;

use App\Http\Controllers\Controller;
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
        return view('foodAndDrinks.index');
    }
}
