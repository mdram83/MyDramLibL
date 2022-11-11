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

    public function show(int $id)
    {
        if ($itemable = auth()->user()->books()->where('books.id', $id)->first()) {
            return view('itemable.show', [
                'itemable' => $itemable,
            ]);
        }
        abort(404);
    }
}
