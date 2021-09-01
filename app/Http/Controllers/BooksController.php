<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {

    }
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());
        return redirect($book->path());
    }
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return redirect($book->path());
    }

    public function delete(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }
}
