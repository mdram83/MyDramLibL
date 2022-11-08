<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Artist;
use App\Models\Book;
use App\Models\ItemableInterface;
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

    private int $numberOfTags = 20;
    private int $numberOfArtists = 50;
    private int $numberOfUsers = 2;
    private int $numberOfPublishers = 20;
    private int $booksPerUser = 20;
    private int $musicAlbumsPerUser = 20;

    private array $tagsPerItem = [
        'min' => 0,
        'max' => 5,
    ];

    private array $artistsPerItem = [
        'min' => 1,
        'max' => 3,
    ];

    private Collection $tags;
    private Collection $artists;
    private Collection $publishers;

    public function run()
    {
        $this->tags = Tag::factory($this->numberOfTags)->create();
        $this->artists = Artist::factory($this->numberOfArtists)->create();
        $this->publishers = Publisher::factory($this->numberOfPublishers)->create();

        User::factory($this->numberOfUsers - 1)->create();
        User::factory()->create([
            'username' => 'mdram83',
            'email' => 'michal.dramowicz.test1@gmail.com',
        ]);

        $users = User::all();

        foreach ($users as $user) {

            $books = Book::factory($this->booksPerUser)->create();
            foreach ($books as $item) {
                $this->createItem($user, $item);
            }

            $musicAlbums = MusicAlbum::factory($this->musicAlbumsPerUser)->create();
            foreach ($musicAlbums as $item) {
                $this->createItem($user, $item);
            }
        }
    }

    private function createItem(User $user, ItemableInterface $itemable)
    {
        $item = Item::factory()->create([
            'user_id' => $user,
            'publisher_id' => $this->publishers->random(),
            'itemable_id' => $itemable,
            'itemable_type' => array_keys(Relation::morphMap(), $itemable::class)[0],
        ]);

        $item->tags()->sync($this->tags->random(rand(
            (int) min($this->tagsPerItem['min'], $this->numberOfTags),
            (int) min($this->tagsPerItem['max'], $this->numberOfTags),
        )));

        $item->artists()->sync($this->artists->random(rand(
            (int) min($this->artistsPerItem['min'], $this->numberOfArtists),
            (int) min($this->artistsPerItem['max'], $this->numberOfArtists),
        )));
    }
}
