<?php

namespace App\Http\Controllers\Journals;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class JournalController extends Controller
{
    /**
     * Index action
     *
     * @return View
     */
    public function index(): View
    {
        return view('journals.index');
    }
}
