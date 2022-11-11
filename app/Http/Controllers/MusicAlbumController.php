<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MusicAlbumController extends Controller
{
    public function index()
    {
        return view('itemables.index', [
            'itemables' => auth()->user()->musicAlbums()->latest()->paginate(10),
            'header' => 'Music Albums',
        ]);
    }
}
