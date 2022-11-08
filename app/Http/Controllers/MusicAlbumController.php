<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MusicAlbumController extends Controller
{
    public function index()
    {
        return view('music.index', [
            'musicAlbums' => auth()->user()->musicAlbums()->latest()->paginate(10),
        ]);
    }
}
