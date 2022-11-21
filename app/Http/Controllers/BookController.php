<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Item;
use App\Models\Publisher;
use App\Models\Tag;
use App\Rules\ArtistName;
use App\Rules\ISBN;
use App\Rules\OneLiner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function create()
    {
        return view('book.create', [
            'header' => 'Add Book',
        ]);
    }

    public function edit(int $id)
    {
        if ($itemable = auth()->user()->books()->where('books.id', $id)->first()) {
            return view('itemable.edit', [
                'itemable' => $itemable,
            ]);
        }
        abort(404);
    }

    public function update(int $id)
    {
        $attributes = request()->validate([
            'isbn' => [new ISBN(), 'nullable'],
            'title' => ['required', 'max:255', new OneLiner()],
            'series' => ['max:255', new OneLiner()],
            'volume' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'pages' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'publisher' => ['max:255', new OneLiner()],
            'published_at' => ['integer', 'min:1901', 'max:2155', 'nullable'],
            'tags.*' => ['string', 'max:30', new OneLiner(), 'nullable'],
            'authors.*' => [new ArtistName(), new OneLiner(), 'string'],
            'comment' => ['string', 'nullable'],
        ]);

        $validator = Validator::make(request()->post(), [
            'thumbnail' => ['max:1000', 'url', 'nullable', new OneLiner()],
        ]);
        $thumbnail = ($validator->fails()) ? null : $validator->safe()->only(['thumbnail'])['thumbnail'];

        dd([$attributes, $thumbnail]);
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
            'tags.*' => ['string', 'max:30', new OneLiner(), 'nullable'],
            'authors.*' => [new ArtistName(), new OneLiner(), 'string'],
            'comment' => ['string', 'nullable'],
        ]);

        $validator = Validator::make(request()->post(), [
            'thumbnail' => ['max:1000', 'url', 'nullable', new OneLiner()],
        ]);
        $thumbnail = ($validator->fails()) ? null : $validator->safe()->only(['thumbnail'])['thumbnail'];

        try {

            DB::beginTransaction();

            $publisher =
                isset($attributes['publisher']) ?
                    Publisher::firstOrCreate(['name' => $attributes['publisher']])
                    : null;

            $tags = collect($attributes['tags'] ?? [])
                ->map(fn($tag) => Tag::firstOrCreate(['name' => $tag]));

            $authors = collect($attributes['authors'] ?? [])
                ->map(function ($author) {
                    $names = explode(', ', $author);
                    $firstname = $names[1] ?? null;
                    $lastname = $names[0];

                    return Author::firstOrCreate(['firstname' => $firstname, 'lastname' => $lastname]);
                });

            $book = Book::create(request()->only(['isbn', 'series', 'volume', 'pages']));

            $item = Item::create(array_merge([
                'user_id' => auth()->user()->id,
                'publisher_id' => $publisher->id ?? null,
                'itemable_id' => $book->id,
                'itemable_type' => $book->getMorphClass(),
                'thumbnail' => $thumbnail,
            ], request()->only(['title', 'published_at', 'comment'])));

            $item->tags()->sync(
                $tags->map(fn($tag) => $tag->id)
            );

            $item->authors()->sync(
                $authors->map(fn($author) => $author->id)
            );

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();

            return redirect()->back()->withErrors([
                'general' => 'Sorry, we encountered unexpected error when saving your item. Please try again.'
            ])->withInput();

        }

        return redirect("/books/{$book->id}")
            ->with('success', 'Your book has been added.');

    }
}
