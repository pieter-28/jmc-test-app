<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\TransportAllowance;

class DashboardController extends Controller
{
    /**
     * Display dashboard based on user role.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->slug ?? null;

        switch ($role) {
            case 'superadmin':
                return $this->superadminDashboard();
            case 'manager-hrd':
                return $this->managerHrdDashboard();
            case 'admin-hrd':
                return $this->adminHrdDashboard();
            default:
                return view('dashboard.default', ['user' => $user]);
        }
    }

    /**
     * Superadmin dashboard - nur Welcomn message.
     */
    private function superadminDashboard()
    {
        return view('dashboard.superadmin', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Manager HRD dashboard - mit widgets and charts.
     */
    private function managerHrdDashboard()
    {
        $totalEmployees = Employee::where('is_active', true)->count();
        $totalContractEmployees = Employee::where('employment_type', 'kontrak')->where('is_active', true)->count();
        $totalPermanentEmployees = Employee::where('employment_type', 'tetap')->where('is_active', true)->count();
        $totalInternships = Employee::where('employment_type', 'magang')->where('is_active', true)->count();

        // Get 5 newest contract employees
        $newestContractEmployees = Employee::where('employment_type', 'kontrak')->where('is_active', true)->latest('start_date')->take(5)->get();

        return view('dashboard.manager-hrd', [
            'user' => Auth::user(),
            'totalEmployees' => $totalEmployees,
            'totalContractEmployees' => $totalContractEmployees,
            'totalPermanentEmployees' => $totalPermanentEmployees,
            'totalInternships' => $totalInternships,
            'newestContractEmployees' => $newestContractEmployees,
        ]);
    }

    /**
     * Admin HRD dashboard - nur Welcome message.
     */
    private function adminHrdDashboard()
    {
        return view('dashboard.admin-hrd', [
            'user' => Auth::user(),
        ]);
    }
}
