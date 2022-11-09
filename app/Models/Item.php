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
        'publisher',
        'authors',
        'mainArtists',
        'mainBands',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function authors()
    {
        return $this->morphedByMany(Author::class, 'artistable', 'artistable_item');
    }

    public function mainArtists()
    {
        return $this->morphedByMany(MainArtist::class, 'artistable', 'artistable_item');
    }

    public function mainBands()
    {
        return $this->morphedByMany(MainBand::class, 'guildable', 'guildable_item');
    }
}
