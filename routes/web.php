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

    Route::controller(BookController::class)->group(function() {
        Route::get('/books', 'index')->name('books');
        Route::get('/books/create', 'create');
        Route::post('/books/store', 'store');
        Route::get('/books/{id}', 'show');
        Route::get('/books/{id}/edit', 'edit');
        Route::patch('/books/{id}', 'update');
        Route::delete('/books/{id}', 'destroy');
    });

    Route::controller(MusicAlbumController::class)->group(function() {
        Route::get('/music', 'index')->name('music');
        Route::get('/music/create', 'create');
        Route::post('/music/store', 'store');
        Route::get('/music/{id}', 'show');
        Route::get('/music/{id}/edit', 'edit');
        Route::patch('/music/{id}', 'update');
        Route::delete('/music/{id}', 'destroy');
    });

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
