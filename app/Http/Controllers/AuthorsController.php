<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store(AuthorRequest $request)
    {
        Author::create($request->validated());
    }
}
