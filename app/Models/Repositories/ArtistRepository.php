<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces\IArtistRepository;
use Illuminate\Support\Collection;

class ArtistRepository implements IArtistRepository
{

    public function getByNames(string $modelClassname, array $names): Collection
    {
        return collect($names)->map(function ($name) use ($modelClassname) {

            $nameParts = explode(', ', $name);
            $firstname = $nameParts[1] ?? null;
            $lastname = $nameParts[0];

            return $modelClassname::firstOrCreate(['firstname' => $firstname, 'lastname' => $lastname]);
        });
    }
}
