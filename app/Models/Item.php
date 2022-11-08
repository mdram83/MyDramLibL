<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'publisher_id',
        'published_at',
        'itemable_id',
        'itemable_type',
        'title',
        'comment',
    ];

    protected $with = [
        'tags',
        'artists',
        'publisher',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
