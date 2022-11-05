<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicAlbum extends Model implements ItemableInterface
{
    use ItemableTrait;

    protected $fillable = [
        'title',
    ];

    use HasFactory;
}
