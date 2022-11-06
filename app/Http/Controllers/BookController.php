<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Item;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return view('books.index', [
            'books' => auth()->user()->books()->paginate(10),
        ]);
    }
}
