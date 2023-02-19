<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function __invoke()
    {

        // recently added items

        // TODO need to figure out how to link user to proper module from itemable type
        // TODO should I have some config array for that (with class name, router name, blade prefix etc.)?
        $items = auth()->user()->items()->withOnly([])->latest()->take(5)->get();

        // recently played music albums

        // recently added friends' items

        // recently added friends

        return view('dashboard', [
            'items' => $items,
        ]);
    }
}
