<?php

use App\Http\Controllers\Ajax\ArtistController;
use App\Http\Controllers\Ajax\EANMusicController;
use App\Http\Controllers\Ajax\GuildController;
use App\Http\Controllers\Ajax\ISBNOpenlibraryController;
use App\Http\Controllers\Ajax\ItemPublishedAtMinMax;
use App\Http\Controllers\Ajax\PlayMusicAlbumController;
use App\Http\Controllers\Ajax\PublisherController;
use App\Http\Controllers\Ajax\TagController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\MusicAlbumController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    if (auth()->id()) {
        return redirect('dashboard');
    }
    return redirect('about');
});

Route::get('/about', fn() => view('welcome'))->name('about');
Route::get('/terms', fn() => view('terms'))->name('terms');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/friends', [FriendsController::class, 'index'])->name('friends');
    Route::get('/friends/accept/{id}', [FriendsController::class, 'accept'])->name('friends.accept');
    Route::get('/friends/reject/{id}', [FriendsController::class, 'reject'])->name('friends.reject');
    Route::get('/friends/remove/{id}', [FriendsController::class, 'remove'])->name('friends.remove');
    Route::post('/friends', [FriendsController::class, 'add'])->name('friends.add');

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
    Route::get('/ajax/play-music-links/{id}', PlayMusicAlbumController::class);
    Route::get('/ajax/item/published-at-min-max', ItemPublishedAtMinMax::class);
});

require __DIR__.'/auth.php';
