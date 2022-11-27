<?php

namespace App\Http\Controllers\Itemables;

use App\Models\Item;
use App\Models\Repositories\Interfaces\IPublisherRepository;
use App\Rules\OneLiner;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use ReflectionClass;

trait ItemableTrait
{
    protected function getUserItemable(int $itemableId, string $userRelationshipName, string $itemableTableName) : Model
    {
        return auth()->user()->$userRelationshipName()->where("{$itemableTableName}.id", $itemableId)->firstOrFail();
    }

    protected function getValidatedThumbnail() : ?string
    {
        $validator = Validator::make(request()->post(), [
            'thumbnail' => ['max:1000', 'url', 'nullable', new OneLiner()],
        ]);
        return ($validator->fails()) ? null : $validator->safe()->only(['thumbnail'])['thumbnail'];
    }

    protected function getCommonItemValidationRules() : array
    {
        return [
            'title' => ['required', 'max:255', new OneLiner()],
            'publisher' => ['max:255', new OneLiner()],
            'published_at' => ['integer', 'min:1901', 'max:2155', 'nullable'],
            'tags.*' => ['string', 'max:30', new OneLiner(), 'nullable'],
            'comment' => ['string', 'nullable'],
        ];
    }

    protected function onItemableSaved(string $uri) : RedirectResponse
    {
        return redirect($uri)->with('success', 'Your item has been saved');
    }

    protected function onItemableSaveError() : RedirectResponse
    {
        return redirect()->back()->withErrors([
            'general' => 'Sorry, we encountered unexpected error when saving your item'
        ])->withInput();
    }

    protected function onIndex(string $userRelationshipName, string $header, string $componentName) : View
    {
        return view('itemables.index', [
            'itemables' => auth()->user()->$userRelationshipName()->latest()->paginate(10),
            'header' => $header,
            'componentName' => $componentName,
        ]);
    }

    protected function onShow(
        int $itemableId,
        string $userRelationshipName,
        string $itemableTableName,
        string $componentName
    ) : View
    {
        return view('itemable.show', [
            'itemable' => $this->getUserItemable($itemableId, $userRelationshipName, $itemableTableName),
            'componentName' => $componentName,
        ]);
    }

    protected function onEdit(int $itemableId, string $userRelationshipName, string $itemableTableName) : View
    {

        $itemable = $this->getUserItemable($itemableId, $userRelationshipName, $itemableTableName);

        return view('itemable.edit', [
            'itemable' => $itemable,
            'componentName' => lcfirst((new ReflectionClass($itemable::class))->getShortName()) . '.edit',
        ]);
    }

    protected function onDestroy(
        int $itemableId,
        string $userRelationshipName,
        string $itemableTableName,
        string $indexRouteName
    ) : RedirectResponse
    {
        $itemable = $this->getUserItemable(
            $itemableId,
            $userRelationshipName,
            $itemableTableName
        );

        try {

            $this->deleteItemable($itemable);

        } catch (Exception) {

            return redirect()->back()->withErrors([
                'general' => 'Sorry, we encountered unexpected error when deleting your item'
            ]);
        }
        return redirect($indexRouteName)->with('success', 'Your item has been deleted');
    }

    protected function deleteItemable(Model $itemable) : void
    {
        try {

            DB::beginTransaction();
            $itemable->item->delete();
            $itemable->delete();
            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            throw new Exception();

        }
    }

    protected function createItem(
        Model $itemable,
        ?string $publisherName,
        IPublisherRepository $publisherRepository) : Item
    {
        return Item::create(array_merge([
            'user_id' => auth()->user()->id,
            'publisher_id' => isset($publisherName)
                ? $publisherRepository->getByName($publisherName)->id
                : null,
            'itemable_id' => $itemable->id,
            'itemable_type' => $itemable->getMorphClass(),
            'thumbnail' => $this->getValidatedThumbnail(),
        ], request()->only(['title', 'published_at', 'comment'])));
    }

    protected function updateItem(
        Item $item,
        ?string $publisherName,
        IPublisherRepository $publisherRepository) : Item
    {
        $item->fill(array_merge([
            'publisher_id' => isset($publisherName)
                ? $publisherRepository->getByName($publisherName)->id
                : null,
            'thumbnail' => $this->getValidatedThumbnail(),
        ], request()->only(['title', 'published_at', 'comment'])));

        if ($item->isDirty()) {
            $item->save();
        }

        return $item;
    }

    protected function updatedItemable(Model $itemable) : void
    {
        $itemable->fill(request()->only($itemable->getFillable()));

        if ($itemable->isDirty()) {
            $itemable->save();
        }
    }
}
