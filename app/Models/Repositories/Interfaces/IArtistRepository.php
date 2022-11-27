<?php

namespace App\Models\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface IArtistRepository
{
    public function getByNames(string $modelClassname, array $names) : Collection;
}
