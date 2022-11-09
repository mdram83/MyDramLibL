<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainBand extends Guild
{
    protected $table = 'guilds';

    public function items()
    {
        return $this->morphToMany(Item::class, 'guildable', 'guildable_item');
    }
}
