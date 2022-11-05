<?php

namespace App\Models;

trait ItemableTrait
{
    public function item() : \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Item::class, 'itemable');
    }
}
