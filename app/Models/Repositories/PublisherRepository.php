<?php

namespace App\Models\Repositories;

use App\Models\Publisher;
use App\Models\Repositories\Interfaces\IPublisherRepository;

class PublisherRepository implements IPublisherRepository
{

    public function getByName(string $name): Publisher
    {
        return Publisher::firstOrCreate(['name' => $name]);
    }
}
