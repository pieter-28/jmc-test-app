<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Province;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display list of employees.
     */
    public function index(Request $request)
    {
        $query = Employee::with('position', 'department', 'subDistrict', 'district', 'province');

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter by position
        if ($request->filled('positions')) {
            $query->whereIn('position_id', $request->input('positions'));
        }

        // Filter by years of service
        if ($request->filled('service_operator') && $request->filled('service_years')) {
            $operator = $request->input('service_operator');
            $years = $request->input('service_years');
            $startDate = now()->subYears($years);

            if ($operator === '>') {
                $query->where('start_date', '<', $startDate);
            } elseif ($operator === '<') {
                $query->where('start_date', '>', $startDate);
            } elseif ($operator === '=') {
                $query->whereBetween('start_date', [$startDate->copy()->startOfYear(), $startDate->copy()->endOfYear()]);
            }
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'nip');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $employees = $query->paginate(10)->appends($request->query());
        $positions = Position::all();

        ActivityLog::log(Auth::id(), 'read', 'Employee', 'Viewed employee list');

        return view('employees.index', compact('employees', 'positions'));
    }

    /**
     * Show create employee form.
     */
    public function create(Request $request)
    {
        $positions = Position::all();
        $departments = Department::all();
        $provinces = Province::all();

        return view('employees.create', [
            'positions' => $positions,
            'departments' => $departments,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Store employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|min:8|unique:employees',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|string',
            'place_of_birth' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'sub_district_id' => 'required|exists:sub_districts,id',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'marital_status' => 'required|in:kawin,tidak kawin',
            'number_of_children' => 'required|integer|min:0|max:99',
            'start_date' => 'required|date',
            'employment_type' => 'required|in:tetap,kontrak,magang',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'education' => 'nullable|array',
        ]);

        $employee = Employee::create($validated);

        // Add education history
        if (! empty($validated['education'])) {
            foreach ($validated['education'] as $edu) {
                $employee->education()->create($edu);
            }
        }

        ActivityLog::log(Auth::id(), 'create', 'Employee', "Created employee: {$employee->name}");

        return redirect()->route('employees.show', $employee)->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Show employee details.
     */
    public function show(Employee $employee)
    {
        ActivityLog::log(Auth::id(), 'read', 'Employee', "Viewed employee: {$employee->name}");

        return view('employees.show', compact('employee'));
    }

    /**
     * Show edit employee form.
     */
    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $departments = Department::all();
        $provinces = Province::all();

        return view('employees.edit', compact('employee', 'positions', 'departments', 'provinces'));
    }

    /**
     * Update employee.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nip' => 'required|string|min:8|unique:employees,nip,'.$employee->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'phone' => 'required|string',
            'place_of_birth' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'sub_district_id' => 'required|exists:sub_districts,id',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'marital_status' => 'required|in:kawin,tidak kawin',
            'number_of_children' => 'required|integer|min:0|max:99',
            'start_date' => 'required|date',
            'employment_type' => 'required|in:tetap,kontrak,magang',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'is_active' => 'nullable|boolean',
            'education' => 'nullable|array',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        $employee->update($data);

        // Update education history
        if ($request->has('education')) {
            $employee->education()->delete();
            foreach ($request->input('education', []) as $edu) {
                if (! empty($edu['level']) && ! empty($edu['institution'])) {
                    $employee->education()->create($edu);
                }
            }
        }

        ActivityLog::log(Auth::id(), 'update', 'Employee', "Updated employee: {$employee->name}");

        return redirect()->route('employees.show', $employee)->with('success', 'Pegawai berhasil diperbarui');
    }

    /**
     * Delete employee.
     */
    public function destroy(Employee $employee)
    {
        $name = $employee->name;
        $employee->delete();

        ActivityLog::log(Auth::id(), 'delete', 'Employee', "Deleted employee: {$name}");

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus');
    }

    /**
     * Export data to Excel.
     */
    public function exportExcel()
    {
        ActivityLog::log(Auth::id(), 'export', 'Employee', 'Exported employee data to Excel');

        return Excel::download(new EmployeesExport, 'daftar-pegawai-'.date('Y-m-d').'.xlsx');
    }

    /**
     * Export data to PDF.
     */
    public function exportPdf()
    {
        $employees = Employee::with(['position', 'department'])->get();
        ActivityLog::log(Auth::id(), 'export', 'Employee', 'Exported employee data to PDF');

        $pdf = Pdf::loadView('employees.pdf', compact('employees'));

        return $pdf->stream('daftar-pegawai-'.date('Y-m-d').'.pdf');
    }
}
