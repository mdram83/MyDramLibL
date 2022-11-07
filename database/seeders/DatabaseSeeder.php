<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\ItemableInterface;
use App\Models\MusicAlbum;
use App\Models\Item;
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
    public function run()
    {
        User::factory(2)->create();
        User::factory()->create([
            'username' => 'mdram83',
            'email' => 'michal.dramowicz.test1@gmail.com',
        ]);

        $users = User::all();

        foreach ($users as $user) {

            $books = Book::factory(25)->create();
            foreach ($books as $item) {
                $this->createItem($user, $item);
            }

            $musicAlbums = MusicAlbum::factory(25)->create();
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
        ]);
    }
}
