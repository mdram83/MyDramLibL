<?php

namespace App\Models\Repositories;

use Illuminate\Support\Collection;

class ArtistRepository implements ArtistRepositoryInterface
{

    public function getArtistsByNames(string $modelClassname, array $names): Collection
    {
        return collect($names)->map(function ($name) use ($modelClassname) {

            $nameParts = explode(', ', $name);
            $firstname = $nameParts[1] ?? null;
            $lastname = $nameParts[0];

            return $modelClassname::firstOrCreate(['firstname' => $firstname, 'lastname' => $lastname]);
        });
    }
}
