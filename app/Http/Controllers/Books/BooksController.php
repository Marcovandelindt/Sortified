<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class BooksController extends Controller
{
    /**
     * Index action
     *
     * @returns View
     */
    public function index()
    {
        return view('books.index');
    }
}
