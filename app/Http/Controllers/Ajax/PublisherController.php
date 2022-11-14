<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index()
    {
        return response()->json(Publisher::orderBy('name')->get(['id', 'name'])->toArray());
    }
}
