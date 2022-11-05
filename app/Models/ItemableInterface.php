<?php

namespace App\Models;

interface ItemableInterface
{
    public function item() : \Illuminate\Database\Eloquent\Relations\MorphOne;
}
