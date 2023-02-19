<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function __invoke()
    {

        // recently added items
        $items = auth()->user()->items()->withOnly([])->latest()->take(5)->get();

        // recently played music albums


        // recently added friends' items

        // recently added friends

        return view('dashboard', [
            'items' => $items,
        ]);
    }
}
