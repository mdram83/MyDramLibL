<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Item;
use App\Rules\ArtistName;
use App\Rules\ISBN;
use App\Rules\OneLiner;
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

    public function create()
    {
        return view('book.create', [
            'header' => 'Add Book',
        ]);
    }

    public function store()
    {
        $attributes = request()->validate([
            'isbn' => [new ISBN(), 'nullable'],
            'title' => ['required', 'max:255', new OneLiner()],
            'series' => ['max:255', new OneLiner()],
            'volume' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'pages' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'publisher' => ['max:255', new OneLiner()],
            'published_at' => ['integer', 'min:1901', 'max:2155', 'nullable'],
            'tags.*' => ['alpha_dash'],
            'authors.*' => [new ArtistName(), new OneLiner()],
            'comment' => ['string', 'nullable'],
        ]);

        ddd($attributes);
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
