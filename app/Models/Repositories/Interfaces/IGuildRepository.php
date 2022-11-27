<?php

namespace App\Models\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface IGuildRepository
{
    public function getByNames(string $modelClassname, array $names) : Collection;
}
