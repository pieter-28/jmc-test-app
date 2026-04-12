<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionApiController extends Controller
{
    public function index()
    {
        return response()->json(Position::all());
    }

    public function show(Position $position)
    {
        return response()->json($position);
    }
}
