<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
