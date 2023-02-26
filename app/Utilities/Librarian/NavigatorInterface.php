<?php

namespace App\Utilities\Librarian;

use App\Models\Item;

interface NavigatorInterface
{
    public function getItemableShowLink(Item $item): string;
    public function getItemableDefaultThumbnail(Item $item): string;
    public function getItemableTypes(): array;
    public function getItemableMenuName(string $itemableType): string;
    public function getItemableDefaultSvgIcon(string $itemableType): string;
    public function getItemableAllLink(string $itemableType): string;
    public function getItemableAddLink(string $itemableType): string;
}
