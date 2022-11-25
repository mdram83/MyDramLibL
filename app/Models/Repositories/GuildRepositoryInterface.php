<?php

namespace App\Models\Repositories;

use Illuminate\Support\Collection;

interface GuildRepositoryInterface
{
    public function getGuildsByNames(string $modelClassname, array $names) : Collection;
}
