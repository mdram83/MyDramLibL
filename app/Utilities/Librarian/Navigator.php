<?php

namespace App\Utilities\Librarian;

use App\Models\Item;

class Navigator implements NavigatorInterface
{
    protected array $libraryMap = [
        'itemables' => [
            'Book' => [
                'routeName' => 'books',
            ],
            'Music Album' => [
                'routeName' => 'music',
            ],
        ],
    ];

    public function getItemableShowLink(Item $item): string
    {
        if (!isset($this->libraryMap['itemables'][$item->itemable_type])) {
            throw new NavigatorException('Itemable type not found');
        }

        return route(
            $this->libraryMap['itemables'][$item->itemable_type]['routeName'] . '.show',
            $item->itemable_id
        );
    }
}
