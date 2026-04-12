<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeApiController extends Controller
{
    public function index()
    {
        return response()->json(Employee::with(['position', 'department'])->paginate(15));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:employees',
            'name' => 'required',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $employee = Employee::create($validated);
        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee->load(['position', 'department']));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:employees,nip,' . $employee->id,
            'name' => 'required',
        ]);

        $employee->update($validated);
        return response()->json($employee);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['message' => 'Employee deleted']);
    }
}
