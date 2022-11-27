<?php

namespace App\Models\Repositories\Interfaces;

use App\Models\Publisher;

interface IPublisherRepository
{
    public function getByName(string $name) : Publisher;
}
