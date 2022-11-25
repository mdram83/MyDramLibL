<?php

namespace App\Models\Repositories;

use App\Models\Publisher;

interface PublisherRepositoryInterface
{
    public function getByName(string $name) : Publisher;
}
