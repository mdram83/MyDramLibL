<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Itemables\ItemableTrait;
use App\Models\Author;
use App\Models\Book;
use App\Models\Repositories\Interfaces\IArtistRepository;
use App\Models\Repositories\Interfaces\IPublisherRepository;
use App\Models\Repositories\Interfaces\ITagRepository;
use App\Rules\ArtistName;
use App\Rules\ISBN;
use App\Rules\OneLiner;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    use ItemableTrait;

    public function __construct(
        protected string $userRelationshipName = 'books',
        protected string $itemableTableName = 'books',
        protected string $indexComponentName = 'book.row-content',
        protected string $showComponentName = 'book.show-content',
        protected string $editComponentName = 'book.edit',
        protected string $indexRouteName = 'books',
        protected string $showUriPrefix = '/books/'
    )
    {

    }

    public function index()
    {
        return $this->onIndex('Books');
    }

    public function show(int $id)
    {
        return $this->onShow($id);
    }

    public function create()
    {
        return view('itemable.create', [
            'header' => 'Add Book',
            'componentName' => 'book.create'
        ]);
    }

    public function edit(int $id)
    {
        return $this->onEdit($id);
    }

    public function destroy(int $id) : RedirectResponse
    {
        return $this->onDestroy($id);
    }

    public function update(
        ITagRepository $tagRepository,
        IPublisherRepository $publisherRepository,
        IArtistRepository $artistRepository,
        int $id
    ) : RedirectResponse
    {
        $attributes = $this->getValidatedAttributes();
        $itemable = $this->getUserItemable($id);

        try {

            DB::beginTransaction();

            $this->updatedItemable($itemable);

            $this->updateItem($itemable->item, $attributes['publisher'] ?? null, $publisherRepository)
                ->syncCollections([
                    'tags' => $tagRepository->getByNames($attributes['tags'] ?? []),
                    'authors' => $artistRepository->getByNames(Author::class, $attributes['authors'] ?? []),
                ]);

            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            return $this->onItemableSaveError();
        }
        return $this->onItemableSaved($itemable->id);
    }

    public function store(
        ITagRepository $tagRepository,
        IPublisherRepository $publisherRepository,
        IArtistRepository $artistRepository
    ) : RedirectResponse
    {
        $attributes = $this->getValidatedAttributes();

        try {

            DB::beginTransaction();

            $itemable = Book::create(request()->only(['isbn', 'series', 'volume', 'pages']));

            $this->createItem($itemable, $attributes['publisher'] ?? null, $publisherRepository)
                ->syncCollections([
                    'tags' => $tagRepository->getByNames($attributes['tags'] ?? []),
                    'authors' => $artistRepository->getByNames(Author::class, $attributes['authors'] ?? []),
                ]);

            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            return $this->onItemableSaveError();
        }
        return $this->onItemableSaved($itemable->id);
    }

    private function getValidatedAttributes() : array
    {
        return request()->validate(array_merge([
            'isbn' => [new ISBN(), 'nullable'],
            'series' => ['max:255', new OneLiner()],
            'volume' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'pages' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'authors.*' => [new ArtistName(), new OneLiner(), 'string'],
        ], $this->getCommonItemValidationRules()));
    }
}
