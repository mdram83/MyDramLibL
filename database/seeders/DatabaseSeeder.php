<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Artist;
use App\Models\Author;
use App\Models\Book;
use App\Models\Guild;
use App\Models\ItemableInterface;
use App\Models\MainArtist;
use App\Models\MainBand;
use App\Models\MusicAlbum;
use App\Models\Item;
use App\Models\Publisher;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    private int $numberOfTags = 10;
    private int $numberOfPublishers = 50;

    private int $numberOfArtists = 200;
    private int $numberOfGuilds = 100;

    private int $numberOfUsers = 5;

    private int $booksPerUser = 20;
    private int $musicAlbumsPerUser = 20;

    private array $tagsPerItem = [
        'min' => 0,
        'max' => 5,
    ];

    private array $authorsPerBook = [
        'min' => 0,
        'max' => 2,
    ];

    private array $mainArtistsPerMusicAlbum = [
        'min' => 1,
        'max' => 2,
    ];

    private array $mainBandsPerMusicAlbum = [
        'min' => 1,
        'max' => 1,
    ];

    private Collection $tags;
    private Collection $publishers;

    private Collection $authors;
    private Collection $mainArtists;
    private Collection $mainBands;

    private Collection $users;

    public function run()
    {
        $this->createBaseModels();
        $this->createItemables();
    }

    private function createBaseModels() : void
    {
        $this->tags = Tag::factory($this->numberOfTags)->create();
        $this->publishers = Publisher::factory($this->numberOfPublishers)->create();

        Artist::factory($this->numberOfArtists)->create();
        $this->authors = Author::all();
        $this->mainArtists = MainArtist::all();

        Guild::factory($this->numberOfGuilds)->create();
        $this->mainBands = MainBand::all();

        User::factory()->create([
            'username' => 'mdram83',
            'email' => 'michal.dramowicz.test1@gmail.com',
        ]);
        User::factory()->create([
            'username' => 'test1',
            'email' => 'test1@testblabla.com',
        ]);
        User::factory()->create([
            'username' => 'test2',
            'email' => 'test2@testblabla.com',
        ]);

        User::factory($this->numberOfUsers - 3)->create();
        $this->users = User::all();
    }

    private function createItemables() : void
    {
        foreach ($this->users as $user) {
            $this->createUserBooks($user);
            $this->createUserMusicAlbums($user);
        }
    }

    private function createUserBooks(User $user) : void
    {
        foreach (Book::factory($this->booksPerUser)->create() as $book) {

            $item = $this->createItem($user, $book);

            $item->authors()->sync($this->getRandomCollectionItems(
                $this->authors,
                $this->authorsPerBook['min'],
                $this->authorsPerBook['max'],
            ));
        }
    }

    private function createUserMusicAlbums(User $user) : void
    {
        foreach (MusicAlbum::factory($this->musicAlbumsPerUser)->create() as $musicAlbum) {

            $item = $this->createItem($user, $musicAlbum);

            $item->mainArtists()->sync($this->getRandomCollectionItems(
                $this->mainArtists,
                $this->mainArtistsPerMusicAlbum['min'],
                $this->mainArtistsPerMusicAlbum['max'],
            ));

            $item->mainBands()->sync($this->getRandomCollectionItems(
                $this->mainBands,
                $this->mainBandsPerMusicAlbum['min'],
                $this->mainBandsPerMusicAlbum['max'],
            ));
        }
    }

    private function createItem(User $user, ItemableInterface $itemable) : Item
    {
        $item = Item::factory()->create([
            'user_id' => $user,
            'publisher_id' => rand(1, 100) >= 40 ? $this->publishers->random() : null,
            'itemable_id' => $itemable,
            'itemable_type' => $itemable->getMorphClass(),
        ]);

        $item->tags()->sync($this->getRandomCollectionItems(
            $this->tags,
            $this->tagsPerItem['min'],
            $this->tagsPerItem['max'],
        ));

        return $item;
    }

    private function getRandomCollectionItems(Collection $collection, int $min, int $max) : ?Collection
    {
        return $collection->random(rand(
            (int) min($min, $collection->count()),
            (int) min($max, $collection->count()),
        ));
    }
}
