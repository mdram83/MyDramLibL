<?php

namespace App\Models\Repositories;

use App\Models\Publisher;

class PublisherRepository implements PublisherRepositoryInterface
{

    public function getByName(string $name): Publisher
    {
        return Publisher::firstOrCreate(['name' => $name]);
    }
}
