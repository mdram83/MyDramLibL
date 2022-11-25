<?php

namespace App\Models\Repositories;

use Illuminate\Support\Collection;

class GuildRepository implements GuildRepositoryInterface
{
    public function getGuildsByNames(string $modelClassname, array $names): Collection
    {
        return collect($names)->map(function ($name) use ($modelClassname) {
            return $modelClassname::firstOrCreate(['name' => $name]);
        });
    }
}
