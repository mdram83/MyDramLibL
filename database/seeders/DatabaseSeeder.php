<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\ItemableInterface;
use App\Models\MusicAlbum;
use App\Models\Item;
use App\Models\User;
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
        $users = User::factory(3)->create();

        foreach ($users as $user) {

            $books = Book::factory(2)->create();
            foreach ($books as $item) {
                $this->createItem($user, $item);
            }

            $musicAlbums = MusicAlbum::factory(2)->create();
            foreach ($musicAlbums as $item) {
                $this->createItem($user, $item);
            }

        }
//
//        $book = Book::factory()->create();
//        Item::factory()->create([
//            'user_id' => $users->first(),
//            'itemable_id' => $book,
//            'itemable_type' => $book::class,
//        ]);
//
//        $musicAlbum = MusicAlbum::factory()->create();
//        Item::factory()->create([
//            'user_id' => $users->first(),
//            'itemable_id' => $musicAlbum,
//            'itemable_type' => $musicAlbum::class,
//        ]);

    }

    private function createItem(User $user, ItemableInterface $itemable)
    {
        Item::factory()->create([
            'user_id' => $user,
            'itemable_id' => $itemable,
            'itemable_type' => $itemable::class,
        ]);
    }
}
