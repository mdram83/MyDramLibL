<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Guild;

class GuildController extends Controller
{
    public function index()
    {
        return response()->json(Guild::orderBy('name')->get(['id', 'name'])->toArray());
    }
}
