<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentApiController extends Controller
{
    public function index()
    {
        return response()->json(Department::all());
    }

    public function show(Department $department)
    {
        return response()->json($department);
    }
}
