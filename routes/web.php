<?php

use App\Http\Controllers\Ajax\ArtistController;
use App\Http\Controllers\Ajax\ISBNOpenlibraryController;
use App\Http\Controllers\Ajax\PublisherController;
use App\Http\Controllers\Ajax\TagController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MusicAlbumController;
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

Route::get('/', fn() => view('welcome'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create']);
    Route::post('/books/store', [BookController::class, 'store']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::get('/books/{id}/edit', [BookController::class, 'edit']);
    Route::patch('/books/{id}', [BookController::class, 'update']);

    Route::get('/music', [MusicAlbumController::class, 'index'])->name('music');
    Route::get('/music/{id}', [MusicAlbumController::class, 'show']);
});

Route::middleware(['auth.ajax'])->group(function() {
    Route::get('/ajax/publishers', [PublisherController::class, 'index']);
    Route::get('/ajax/tags', [TagController::class, 'index']);
    Route::get('/ajax/artists', [ArtistController::class, 'index']);
    Route::get('/ajax/isbn/{isbn}', [ISBNOpenlibraryController::class, 'show']);
});

require __DIR__.'/auth.php';
