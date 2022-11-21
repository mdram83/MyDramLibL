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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        if ($book = auth()->user()->books()->where('books.id', $id)->first()) {
            return view('itemable.show', [
                'itemable' => $book,
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
        if ($book = auth()->user()->books()->where('books.id', $id)->first()) {
            return view('itemable.edit', [
                'itemable' => $book,
            ]);
        }
        abort(404);
    }

    public function update(int $id)
    {
        $attributes = $this->getValidatedAttributes();

        try {

            DB::beginTransaction();

            $book = auth()->user()->books()->where('books.id', $id)->firstOrFail();
            $book->fill(request()->only(['isbn', 'series', 'volume', 'pages']));
            if ($book->isDirty()) {
                $book->save();
            }

            $book->item->fill(array_merge([
                'publisher_id' => $this->getPublisherByName($attributes['publisher'] ?? null)?->id,
            ], request()->only(['title', 'published_at', 'comment', 'thumbnail'])));
            if ($book->item->isDirty()) {
                $book->item->save();
            }

            $this->syncItemWithTagsAndAuthors(
                $book->item,
                $this->getTagsByNames($attributes['tags'] ?? []),
                $this->getAuthorsByNames($attributes['authors'] ?? [])
            );

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            return $this->onBookSaveErrors();
        }
        return $this->onBookSaved($book->id);
    }

    public function store()
    {
        $attributes = $this->getValidatedAttributes();

        try {

            DB::beginTransaction();

            $book = Book::create(request()->only(['isbn', 'series', 'volume', 'pages']));

            $item = Item::create(array_merge([
                'user_id' => auth()->user()->id,
                'publisher_id' => $this->getPublisherByName($attributes['publisher'] ?? null)?->id,
                'itemable_id' => $book->id,
                'itemable_type' => $book->getMorphClass(),
            ], request()->only(['title', 'published_at', 'comment', 'thumbnail'])));

            $this->syncItemWithTagsAndAuthors(
                $item,
                $this->getTagsByNames($attributes['tags'] ?? []),
                $this->getAuthorsByNames($attributes['authors'] ?? [])
            );

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            return $this->onBookSaveErrors();
        }
        return $this->onBookSaved($book->id);
    }

    private function getValidatedAttributes() : array
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
        $thumbnail = ($validator->fails()) ? null : $validator->safe()->only(['thumbnail']);

        return array_merge($attributes, $thumbnail);
    }

    private function getPublisherByName(?string $name) : ?Publisher
    {
        return isset($name) ? Publisher::firstOrCreate(['name' => $name]) : null;
    }

    private function getTagsByNames(array $names) : Collection
    {
        return collect($names)->map(fn($tag) => Tag::firstOrCreate(['name' => $tag]));
    }

    private function getAuthorsByNames(array $names) : Collection
    {
        return collect($names)->map(function ($name) {

            $nameParts = explode(', ', $name);
            $firstname = $nameParts[1] ?? null;
            $lastname = $nameParts[0];

            return Author::firstOrCreate(['firstname' => $firstname, 'lastname' => $lastname]);
        });
    }

    private function syncItemWithTagsAndAuthors(Item $item, Collection $tags, Collection $authors) : void
    {
        $item->tags()->sync($tags->map(fn($tag) => $tag->id));
        $item->authors()->sync($authors->map(fn($author) => $author->id));
    }

    private function onBookSaved(int $id) : RedirectResponse
    {
        return redirect("/books/{$id}")->with('success', 'Your book has been saved.');
    }

    private function onBookSaveErrors() : RedirectResponse
    {
        return redirect()->back()->withErrors([
            'general' => 'Sorry, we encountered unexpected error when saving your item. Please try again.'
        ])->withInput();
    }
}
