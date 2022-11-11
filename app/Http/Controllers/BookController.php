<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Item;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return view('itemables.index', [
            'itemables' => auth()->user()->books()->latest()->paginate(10),
            'header' => 'Books',
        ]);
    }
}
