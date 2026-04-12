<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransportAllowanceSetting;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TransportAllowanceSettingController extends Controller
{
    /**
     * Display list of settings.
     */
    public function index()
    {
        $settings = TransportAllowanceSetting::latest('effective_date')->paginate(15);
        $activeSetting = TransportAllowanceSetting::getActiveSettings();

        ActivityLog::log(Auth::id(), 'read', 'TransportSettings', 'Viewed transport settings');

        return view('transport-settings.index', compact('settings', 'activeSetting'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('transport-settings.create');
    }

    /**
     * Store new setting.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'base_fare' => 'required|numeric|min:0',
            'min_distance' => 'required|numeric|min:0',
            'max_distance' => 'required|numeric|min:0',
            'min_working_days' => 'required|integer|min:0|max:31',
            'effective_date' => 'required|date',
        ]);

        $setting = TransportAllowanceSetting::create($validated);

        ActivityLog::log(Auth::id(), 'create', 'TransportSettings', 'Created new transport settings');

        return redirect()->route('transport-settings.index')->with('success', 'Pengaturan tunjangan berhasil ditambahkan');
    }
}
