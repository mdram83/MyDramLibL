<?php

namespace App\Models\Repositories;

use Illuminate\Support\Collection;

interface ArtistRepositoryInterface
{
    public function getArtistsByNames(string $modelClassname, array $names) : Collection;
}
