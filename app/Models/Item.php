<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'published_at',
        'itemable_id',
        'itemable_type',
        'title',
    ];

    protected $with = ['itemable'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
