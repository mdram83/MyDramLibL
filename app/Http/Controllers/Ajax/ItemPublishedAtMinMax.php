<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Exception;

class ItemPublishedAtMinMax extends Controller
{
    public function __invoke()
    {
        try {
            $data = [
                'publishedAtMin' => Item::min('published_at'),
                'publishedAtMax' => Item::max('published_at'),
            ];

        } catch (Exception) {
            return response()->json([], 500);
        }

        return response()->json($data);
    }
}
