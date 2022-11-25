<?php

namespace App\Models\Repositories;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagRepository implements TagRepositoryInterface
{
    public function getByNames(array $names) : Collection
    {
        return collect($names)->map(fn($tag) => Tag::firstOrCreate(['name' => $tag]));
    }
}
