<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model implements ItemableInterface
{
    use ItemableTrait;

    protected $fillable = [
        'title',
        'isbn',
    ];

    use HasFactory;
}
