<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainArtist extends Artist
{
    protected $table = 'artists';

    public function items()
    {
        return $this->morphToMany(Item::class, 'artistable', 'artistable_item');
    }
}
