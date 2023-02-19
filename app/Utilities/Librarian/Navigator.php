<?php

namespace App\Utilities\Librarian;

use App\Models\Item;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class Navigator
{

    protected const LIBRARY_MAP = [
        'itemables' => [
            'Book' => [
                'routeName' => 'books',
            ],
            'Music Album' => [
                'routeName' => 'music',
            ],
        ],
    ];

    public static function getItemableShowLink(Item $item): string
    {
        return route(
            static::LIBRARY_MAP['itemables'][$item->itemable_type]['routeName'] . '.show',
            $item->itemable_id
        );
    }
}
