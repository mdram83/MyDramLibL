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

    public function show(int $id)
    {
        if ($itemable = auth()->user()->musicAlbums()->where('music_albums.id', $id)->first()) {
            return view('itemable.show', [
                'itemable' => $itemable,
            ]);
        }
        abort(404);
    }

    public function create()
    {
        return view('music.create', [
            'header' => 'Add Music Album',
        ]);
    }

    public function store()
    {
        dd(request()->all());
    }
}
