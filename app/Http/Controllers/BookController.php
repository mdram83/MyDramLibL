<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Item;
use App\Models\Publisher;
use App\Models\Repositories\ArtistRepositoryInterface;
use App\Models\Repositories\PublisherRepositoryInterface;
use App\Models\Repositories\TagRepositoryInterface;
use App\Models\Tag;
use App\Rules\ArtistName;
use App\Rules\ISBN;
use App\Rules\OneLiner;
use Exception;
use Illuminate\Http\RedirectResponse;
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

    public function destroy(int $id) : RedirectResponse
    {
        $book = auth()->user()->books()->where('books.id', $id)->firstOrFail();

        try {
            DB::beginTransaction();
            $book->item->delete();
            $book->delete();
            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            return redirect()->back()->withErrors([
                'general' => 'Sorry, we encountered unexpected error when deleting your item. Please try again.'
            ]);
        }
        return redirect('books')->with('success', 'Your book has been deleted');
    }

    public function update(
        int $id,
        TagRepositoryInterface $tagRepository,
        PublisherRepositoryInterface $publisherRepository,
        ArtistRepositoryInterface $artistRepository
    ) : RedirectResponse
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
                'publisher_id' => isset($attributes['publisher'])
                    ? $publisherRepository->getByName($attributes['publisher'])->id
                    : null,
            ], request()->only(['title', 'published_at', 'comment', 'thumbnail'])));
            if ($book->item->isDirty()) {
                $book->item->save();
            }

            $book->item->syncCollections([
                'tags' => $tagRepository->getByNames($attributes['tags'] ?? []),
                'authors' => $artistRepository->getArtistsByNames(
                    Author::class,
                    $attributes['authors'] ?? []
                ),
            ]);

            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            return $this->onBookSaveErrors();
        }
        return $this->onBookSaved($book->id);
    }

    public function store(
        TagRepositoryInterface $tagRepository,
        PublisherRepositoryInterface $publisherRepository,
        ArtistRepositoryInterface $artistRepository
    ) : RedirectResponse
    {
        $attributes = $this->getValidatedAttributes();

        try {

            DB::beginTransaction();

            $book = Book::create(request()->only(['isbn', 'series', 'volume', 'pages']));

            $item = Item::create(array_merge([
                'user_id' => auth()->user()->id,
                'publisher_id' =>  isset($attributes['publisher'])
                    ? $publisherRepository->getByName($attributes['publisher'])->id
                    : null,
                'itemable_id' => $book->id,
                'itemable_type' => $book->getMorphClass(),
            ], request()->only(['title', 'published_at', 'comment', 'thumbnail'])));

            $item->syncCollections([
                'tags' => $tagRepository->getByNames($attributes['tags'] ?? []),
                'authors' => $artistRepository->getArtistsByNames(
                    Author::class,
                    $attributes['authors'] ?? []
                ),
            ]);

            DB::commit();

        } catch (Exception) {

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
