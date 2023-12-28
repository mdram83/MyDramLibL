<?php

namespace App\Models;

use App\Utilities\Request\UndecodedRequestParamsInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MusicAlbum extends Model implements ItemableInterface
{
    use ItemableTrait;
    use HasFactory;

    protected $fillable = [
        'ean',
        'duration',
        'volumes',
        'links',
        'play_count',
        'played_on',
    ];

    protected $with = [
        'item',
    ];

    public function getMainBands() : ?Collection
    {
        return $this->item->mainBands;
    }

    public function getMainArtists() : ?Collection
    {
        return $this->item->mainArtists;
    }

    public function scopeUsingClassSpecificQueryString(
        $query,
        Request $request,
        UndecodedRequestParamsInterface $undecodedRequestParams
    )
    {
        $queryParams = $request->query();

        // specific filters implementation goes here

        return $query;
    }
}
