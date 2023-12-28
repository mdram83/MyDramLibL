<?php

namespace App\Models;

use App\Utilities\Request\UndecodedRequestParamsInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Book extends Model implements ItemableInterface
{
    use ItemableTrait;
    use HasFactory;

    protected $fillable = [
        'isbn',
        'series',
        'volume',
        'pages',
    ];

    protected $with = [
        'item',
    ];

    public function getAuthors(): Collection
    {
        return $this->item->authors;
    }

    public function scopeUsingClassSpecificQueryString(
        $query,
        Request $request,
        UndecodedRequestParamsInterface $undecodedRequestParams
    )
    {
        $queryParams = $request->query();

        if (isset($queryParams['authors'])) {

            $artistsNamesFromQueryString = array_map(
                fn($item) => rawurldecode($item),
                explode(',', $undecodedRequestParams->get('authors'))
            );

            $artistsNamesWithIdKeys = [];
            foreach(Artist::all() as $artist) {
                $artistsNamesWithIdKeys[$artist->id] = $artist->getName();
            }

            $requestedArtistsIds = array_keys(array_intersect($artistsNamesWithIdKeys, $artistsNamesFromQueryString));

            $query = $query->whereHas('item', function($query) use ($requestedArtistsIds) {
                $query->whereHas('authors', function($query) use ($requestedArtistsIds) {
                    $query->whereIn('artistable_id', $requestedArtistsIds);
                });
            });
        }

        return $query;
    }
}
