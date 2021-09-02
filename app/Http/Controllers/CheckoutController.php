<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function store(Book $book)
    {
        $book->checkout(auth()->user());
    }
}
