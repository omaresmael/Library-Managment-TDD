<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(BookRequest $request)
    {
        Book::create($request->validated());
    }
    public function update(BookRequest $request, Book $book)
    {

        $book->update($request->validated());
    }
}
