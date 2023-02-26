<?php

namespace App\Http\Controllers;

use App\Utilities\Librarian\NavigatorInterface;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function __invoke(NavigatorInterface $navigator)
    {

        // recently added friends' items
        // recently added friends

        return view('dashboard', [
            'items' => auth()->user()->items()->withOnly([])->latest()->take(5)->get(),
            'played' => auth()->user()->musicAlbums()
                ->where('played_on', '>', '0')
                ->orderBy('played_on', 'desc')
                ->take(5)
                ->get(),
        ]);
    }
}
