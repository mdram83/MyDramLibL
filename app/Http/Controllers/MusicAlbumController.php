<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MainArtist;
use App\Models\MainBand;
use App\Models\MusicAlbum;
use App\Models\Publisher;
use App\Models\Repositories\ArtistRepositoryInterface;
use App\Models\Repositories\GuildRepositoryInterface;
use App\Models\Repositories\PublisherRepositoryInterface;
use App\Models\Repositories\TagRepositoryInterface;
use App\Models\Tag;
use App\Rules\ArtistName;
use App\Rules\Duration;
use App\Rules\EAN;
use App\Rules\OneLiner;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MusicAlbumController extends Controller
{
    public function index()
    {
        return view('itemables.index', [
            'itemables' => auth()->user()->musicAlbums()->latest()->paginate(10),
            'header' => 'Music Albums',
        ]);
    }

    public function show(int $id)
    {
        if ($itemable = auth()->user()->musicAlbums()->where('music_albums.id', $id)->first()) {
            return view('itemable.show', [
                'itemable' => $itemable,
            ]);
        }
        abort(404);
    }

    public function create()
    {
        return view('music.create', [
            'header' => 'Add Music Album',
        ]);
    }

    public function store(
        TagRepositoryInterface $tagRepository,
        PublisherRepositoryInterface $publisherRepository,
        ArtistRepositoryInterface $artistRepository,
        GuildRepositoryInterface $guildRepository
    ) : RedirectResponse
    {

        $attributes = $this->getValidatedAttributes();

        try {

            DB::beginTransaction();

            $musicAlbum = MusicAlbum::create(request()->only(['ean', 'duration', 'volumes']));

            $item = Item::create(array_merge([
                'user_id' => auth()->user()->id,
                'publisher_id' => isset($attributes['publisher'])
                    ? $publisherRepository->getByName($attributes['publisher'])->id
                    : null,
                'itemable_id' => $musicAlbum->id,
                'itemable_type' => $musicAlbum->getMorphClass(),
            ], request()->only(['title', 'published_at', 'comment', 'thumbnail'])));

            $item->syncCollections([
                'tags' => $tagRepository->getByNames($attributes['tags'] ?? []),
                'mainArtists' => $artistRepository->getArtistsByNames(
                    MainArtist::class,
                    $attributes['mainArtists'] ?? []
                ),
                'mainBands' => $guildRepository->getGuildsByNames(
                    MainBand::class,
                    $attributes['mainBands'] ?? []
                ),
            ]);

            DB::commit();

        } catch (Exception) {

            DB::rollBack();
            return $this->onMusicAlbumSaveErrors();
        }
        return $this->onMusicAlbumSaved($musicAlbum->id);
    }

    private function getValidatedAttributes() : array
    {
        $attributes = request()->validate([
            'ean' => [new EAN(), 'nullable'],
            'title' => ['required', 'max:255', new OneLiner()],
            'duration' => [new Duration(), 'nullable'],
            'volumes' => ['integer', 'min:1', 'max:9999', 'nullable'],
            'publisher' => ['max:255', new OneLiner()],
            'published_at' => ['integer', 'min:1901', 'max:2155', 'nullable'],
            'tags.*' => ['string', 'max:30', new OneLiner(), 'nullable'],
            'mainArtists.*' => [new ArtistName(), new OneLiner(), 'string'],
            'mainBands.*' => ['max:255', new OneLiner()],
            'comment' => ['string', 'nullable'],
        ]);

        $validator = Validator::make(request()->post(), [
            'thumbnail' => ['max:1000', 'url', 'nullable', new OneLiner()],
        ]);
        $thumbnail = ($validator->fails()) ? null : $validator->safe()->only(['thumbnail']);

        return array_merge($attributes, $thumbnail);
    }

    private function onMusicAlbumSaved(int $id) : RedirectResponse
    {
        return redirect("/music/{$id}")->with('success', 'Your album has been saved.');
    }

    private function onMusicAlbumSaveErrors() : RedirectResponse
    {
        return redirect()->back()->withErrors([
            'general' => 'Sorry, we encountered unexpected error when saving your item. Please try again.'
        ])->withInput();
    }
}
