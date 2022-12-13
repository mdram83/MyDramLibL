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

Route::get('/', fn() => view('welcome'))->name('about');
Route::get('/terms', fn() => view('terms'))->name('terms');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::resource('books', BookController::class)->names([
       'index' => 'books',
    ]);
    Route::resource('music', MusicAlbumController::class)->names([
        'index' => 'music',
    ]);
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
