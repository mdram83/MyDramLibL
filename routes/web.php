<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/books', [BookController::class, 'index'])->name('books');

    Route::get('/music', [MusicAlbumController::class, 'index'])->name('music');

});

require __DIR__.'/auth.php';
