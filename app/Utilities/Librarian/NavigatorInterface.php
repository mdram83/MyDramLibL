<?php

namespace App\Utilities\Librarian;

use App\Models\Item;

interface NavigatorInterface
{
    public function getItemableShowLink(Item $item): string;
    public function getItemableDefaultThumbnail(Item $item): string;
}
