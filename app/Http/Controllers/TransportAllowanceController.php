<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransportAllowance;
use App\Models\TransportAllowanceSetting;
use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TransportAllowanceController extends Controller
{
    /**
     * Display list of transport allowances.
     */
    public function index(Request $request)
    {
        $query = TransportAllowance::with('employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->input('employee_id'));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }

        if ($request->filled('month')) {
            $query->where('month', $request->input('month'));
        }

        $allowances = $query->paginate(15);
        $employees = Employee::where('employment_type', 'tetap')->get();

        ActivityLog::log(Auth::id(), 'read', 'TransportAllowance', 'Viewed transport allowance list');

        return view('transport-allowances.index', compact('allowances', 'employees'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $employees = Employee::where('employment_type', 'tetap')->get();
        $years = range(date('Y') - 5, date('Y'));

        return view('transport-allowances.create', compact('employees', 'years'));
    }

    /**
     * Store transport allowance.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'month' => 'required|integer|min:1|max:12',
            'distance' => 'required|numeric|min:0',
            'working_days' => 'required|integer|min:0|max:31',
        ]);

        $employee = Employee::find($validated['employee_id']);
        $amount = TransportAllowance::calculateAllowance($employee, $validated['distance'], $validated['working_days'], $validated['month'], $validated['year']);

        $allowance = TransportAllowance::create([
            'employee_id' => $validated['employee_id'],
            'year' => $validated['year'],
            'month' => $validated['month'],
            'distance' => $validated['distance'],
            'working_days' => $validated['working_days'],
            'amount' => $amount,
        ]);

        ActivityLog::log(Auth::id(), 'create', 'TransportAllowance', "Created allowance for employee: {$employee->name}");

        return redirect()->route('transport-allowances.show', $allowance)->with('success', 'Tunjangan transport berhasil ditambahkan');
    }

    /**
     * Show transport allowance details.
     */
    public function show(TransportAllowance $allowance)
    {
        ActivityLog::log(Auth::id(), 'read', 'TransportAllowance', "Viewed allowance for: {$allowance->employee->name}");

        return view('transport-allowances.show', compact('allowance'));
    }

    /**
     * Show edit form.
     */
    public function edit(TransportAllowance $allowance)
    {
        $employees = Employee::where('employment_type', 'tetap')->get();
        $years = range(date('Y') - 5, date('Y'));

        return view('transport-allowances.edit', compact('allowance', 'employees', 'years'));
    }

    /**
     * Update transport allowance.
     */
    public function update(Request $request, TransportAllowance $allowance)
    {
        $validated = $request->validate([
            'distance' => 'required|numeric|min:0',
            'working_days' => 'required|integer|min:0|max:31',
        ]);

        $employee = $allowance->employee;
        $amount = TransportAllowance::calculateAllowance($employee, $validated['distance'], $validated['working_days'], $allowance->month, $allowance->year);

        $allowance->update([
            'distance' => $validated['distance'],
            'working_days' => $validated['working_days'],
            'amount' => $amount,
        ]);

        ActivityLog::log(Auth::id(), 'update', 'TransportAllowance', "Updated allowance for: {$employee->name}");

        return redirect()->route('transport-allowances.show', $allowance)->with('success', 'Tunjangan transport berhasil diperbarui');
    }

    /**
     * Delete transport allowance.
     */
    public function destroy(TransportAllowance $allowance)
    {
        $employee = $allowance->employee->name;
        $allowance->delete();

        ActivityLog::log(Auth::id(), 'delete', 'TransportAllowance', "Deleted allowance for: {$employee}");

        return redirect()->route('transport-allowances.index')->with('success', 'Tunjangan transport berhasil dihapus');
    }
}
