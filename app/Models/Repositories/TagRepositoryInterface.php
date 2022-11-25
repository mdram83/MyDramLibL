<?php

namespace App\Models\Repositories;

use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    public function getByNames(array $names) : Collection;
}
