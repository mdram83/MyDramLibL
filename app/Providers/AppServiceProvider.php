<?php

namespace App\Providers;

use App\Utilities\API\ISBN\ISBNRestAPI;
use App\Utilities\API\ISBN\OpenlibraryISBNRestAPI;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(ISBNRestAPI::class, fn() => new OpenlibraryISBNRestAPI(new Client()));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'Book' => 'App\Models\Book',
            'Music Album' => 'App\Models\MusicAlbum',
            'Author' => 'App\Models\Author',
            'Main Artist' => 'App\Models\MainArtist',
            'Main Band' => 'App\Models\MainBand',
        ]);
    }
}
