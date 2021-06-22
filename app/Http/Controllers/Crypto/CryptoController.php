<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CryptoController extends Controller
{
    /**
     * Index action
     *
     * @return View
     */
    public function index(): View
    {
        return view('crypto.index');
    }
}
