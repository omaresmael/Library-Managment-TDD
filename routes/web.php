<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/books',[BooksController::class,'index']);
Route::post('/books',[BooksController::class,'store']);
Route::patch('/books/{book}',[BooksController::class,'update']);
Route::delete('/books/{book}',[BooksController::class,'delete']);

Route::post('/authors',[AuthorsController::class,'store']);

Route::post('/checkout/{book}',[CheckoutController::class,'store']);

Route::post('/checkin/{book}', [CheckinController::class,'store']);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
