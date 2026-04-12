<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function index()
    {
        return response()->json(User::with('role')->paginate(15));
    }

    public function show(User $user)
    {
        return response()->json($user->load('role'));
    }
}
