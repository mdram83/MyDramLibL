<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces\IGuildRepository;
use Illuminate\Support\Collection;

class GuildRepository implements IGuildRepository
{
    public function getByNames(string $modelClassname, array $names): Collection
    {
        return collect($names)->map(function ($name) use ($modelClassname) {
            return $modelClassname::firstOrCreate(['name' => $name]);
        });
    }
}
