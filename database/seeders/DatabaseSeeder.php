<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\ItemableInterface;
use App\Models\MusicAlbum;
use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
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
    private int $numberOfUsers = 2;
    private int $numberOfBooks = 25;
    private int $numberOfMusicAlbums = 25;

    public function run()
    {
        Tag::factory($this->numberOfTags)->create();

        User::factory($this->numberOfUsers - 1)->create();
        User::factory()->create([
            'username' => 'mdram83',
            'email' => 'michal.dramowicz.test1@gmail.com',
        ]);

        $users = User::all();

        foreach ($users as $user) {

            $books = Book::factory($this->numberOfBooks)->create();
            foreach ($books as $item) {
                $this->createItem($user, $item);
            }

            $musicAlbums = MusicAlbum::factory($this->numberOfMusicAlbums)->create();
            foreach ($musicAlbums as $item) {
                $this->createItem($user, $item);
            }
        }
    }

    private function createItem(User $user, ItemableInterface $itemable)
    {
        Item::factory()->create([
            'user_id' => $user,
            'itemable_id' => $itemable,
            'itemable_type' => array_keys(Relation::morphMap(), $itemable::class)[0],
        ])->tags()->sync(Tag::where('id', rand(1, $this->numberOfTags))->get()->first());
    }
}
