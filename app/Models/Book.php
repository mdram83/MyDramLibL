<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model implements ItemableInterface
{
    use ItemableTrait;
    use HasFactory;

    protected $fillable = [
        'title',
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
}
