<?php

namespace App\Providers;

use App\Models\Repositories\ArtistRepository;
use App\Models\Repositories\ArtistRepositoryInterface;
use App\Models\Repositories\GuildRepository;
use App\Models\Repositories\GuildRepositoryInterface;
use App\Models\Repositories\PublisherRepository;
use App\Models\Repositories\PublisherRepositoryInterface;
use App\Models\Repositories\TagRepository;
use App\Models\Repositories\TagRepositoryInterface;
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
        app()->bind(TagRepositoryInterface::class, fn() => new TagRepository());
        app()->bind(PublisherRepositoryInterface::class, fn() => new PublisherRepository());
        app()->bind(ArtistRepositoryInterface::class, fn() => new ArtistRepository());
        app()->bind(GuildRepositoryInterface::class, fn() => new GuildRepository());
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
