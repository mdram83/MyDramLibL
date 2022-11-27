<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Itemables\ItemableTrait;
use App\Models\MainArtist;
use App\Models\MainBand;
use App\Models\MusicAlbum;
use App\Models\Repositories\Interfaces\IArtistRepository;
use App\Models\Repositories\Interfaces\IGuildRepository;
use App\Models\Repositories\Interfaces\IPublisherRepository;
use App\Models\Repositories\Interfaces\ITagRepository;
use App\Rules\ArtistName;
use App\Rules\Duration;
use App\Rules\EAN;
use App\Rules\OneLiner;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class MusicAlbumController extends Controller
{
    use ItemableTrait;

    public function index()
    {
        return $this->onIndex('musicAlbums', 'Music Albums', 'musicAlbum.row-content');
    }

    public function show(int $id)
    {
        return $this->onShow($id, 'musicAlbums', 'music_albums', 'musicAlbum.show-content');
    }

    public function create()
    {
        return view('itemable.create', [
            'header' => 'Add Music Album',
            'componentName' => 'musicAlbum.create'
        ]);
    }

    public function edit(int $id)
    {
        return $this->onEdit($id, 'musicAlbums', 'music_albums');
    }

    public function destroy(int $id) : RedirectResponse
    {
        return $this->onDestroy($id, 'musicAlbums', 'music_albums', 'music');
    }

    public function update(
        int $id,
        ITagRepository $tagRepository,
        IPublisherRepository $publisherRepository,
        IArtistRepository $artistRepository,
        IGuildRepository $guildRepository
    ) : RedirectResponse
    {
        $attributes = $this->getValidatedAttributes();
        $itemable = $this->getUserItemable($id, 'musicAlbums', 'music_albums');

        try {

            DB::beginTransaction();

            $this->updatedItemable($itemable);

            $this->updateItem($itemable->item, $attributes['publisher'] ?? null, $publisherRepository)
                ->syncCollections([
                    'tags' => $tagRepository->getByNames($attributes['tags'] ?? []),
                    'mainArtists' => $artistRepository->getByNames(MainArtist::class, $attributes['mainArtists'] ?? []),
                    'mainBands' => $guildRepository->getByNames(MainBand::class, $attributes['mainBands'] ?? []),
                ]);

            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            return $this->onItemableSaveError();
        }
        return $this->onItemableSaved("/music/{$itemable->id}");
    }

    public function store(
        ITagRepository $tagRepository,
        IPublisherRepository $publisherRepository,
        IArtistRepository $artistRepository,
        IGuildRepository $guildRepository
    ) : RedirectResponse
    {
        $attributes = $this->getValidatedAttributes();

        try {

            DB::beginTransaction();

            $itemable = MusicAlbum::create(request()->only(['ean', 'duration', 'volumes']));

            $this->createItem($itemable, $attributes['publisher'] ?? null, $publisherRepository)
                ->syncCollections([
                    'tags' => $tagRepository->getByNames($attributes['tags'] ?? []),
                    'mainArtists' => $artistRepository->getByNames(MainArtist::class, $attributes['mainArtists'] ?? []),
                    'mainBands' => $guildRepository->getByNames(MainBand::class, $attributes['mainBands'] ?? []),
                ]);

            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            return $this->onItemableSaveError();
        }
        return $this->onItemableSaved("/music/{$itemable->id}");
    }

    private function getValidatedAttributes() : array
    {
        return request()->validate(array_merge([
            'ean' => [new EAN(), 'nullable'],
            'duration' => [new Duration(), 'nullable'],
            'volumes' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'mainArtists.*' => [new ArtistName(), new OneLiner(), 'string'],
            'mainBands.*' => ['max:255', new OneLiner()],
        ], $this->getCommonItemValidationRules()));
    }
}
