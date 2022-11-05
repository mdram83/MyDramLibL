<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\MusicAlbum;
use App\Models\Title;
use App\Models\TitleType;
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
        $users = User::factory(2)->create();

        $bookTitleType = TitleType::factory()->create(['code' => 'Book', 'name' => 'Book']);
        $musicTitleType = TitleType::factory()->create(['code' => 'MusicAlbum', 'name' => 'Music Album']);

        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {

                Book::factory()->create([
                    'title_id' => Title::factory()->create([
                        'user_id' => $user,
                        'title_type_id' => $bookTitleType,
                    ]),
                ]);

                MusicAlbum::factory()->create([
                    'title_id' => Title::factory()->create([
                        'user_id' => $user,
                        'title_type_id' => $musicTitleType,
                    ]),
                ]);

            }
        }

    }
}
