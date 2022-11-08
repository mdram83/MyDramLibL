<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function getName() : string
    {
        return trim("{$this->firstname} {$this->lastname}");
    }
}
