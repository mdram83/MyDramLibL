<?php

use App\Http\Controllers\Ajax\ArtistController;
use App\Http\Controllers\Ajax\EANMusicController;
use App\Http\Controllers\Ajax\GuildController;
use App\Http\Controllers\Ajax\ISBNOpenlibraryController;
use App\Http\Controllers\Ajax\PublisherController;
use App\Http\Controllers\Ajax\TagController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MusicAlbumController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create']);
    Route::post('/books/store', [BookController::class, 'store']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::get('/books/{id}/edit', [BookController::class, 'edit']);
    Route::patch('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    Route::get('/music', [MusicAlbumController::class, 'index'])->name('music');
    Route::get('/music/create', [MusicAlbumController::class, 'create']);
    Route::post('/music/store', [MusicAlbumController::class, 'store']);
    Route::get('/music/{id}', [MusicAlbumController::class, 'show']);
    Route::get('/music/{id}/edit', [MusicAlbumController::class, 'edit']);
    Route::patch('/music/{id}', [MusicAlbumController::class, 'update']);
    Route::delete('/music/{id}', [MusicAlbumController::class, 'destroy']);
});


Route::middleware(['auth.ajax'])->group(function() {

    Route::get('/ajax/publishers', [PublisherController::class, 'index']);
    Route::get('/ajax/tags', [TagController::class, 'index']);
    Route::get('/ajax/artists', [ArtistController::class, 'index']);
    Route::get('/ajax/guilds', [GuildController::class, 'index']);
    Route::get('/ajax/isbn/{isbn}', [ISBNOpenlibraryController::class, 'show']);
    Route::get('/ajax/ean/{ean}', [EANMusicController::class, 'show']);
});

require __DIR__.'/auth.php';
