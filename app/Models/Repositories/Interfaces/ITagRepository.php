<?php

namespace App\Models\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface ITagRepository
{
    public function getByNames(array $names) : Collection;
}
