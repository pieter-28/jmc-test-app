<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display list of roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(15);

        ActivityLog::log(Auth::id(), 'read', 'Role', 'Viewed role list');

        return view('roles.index', compact('roles'));
    }

    /**
     * Show role details.
     */
    public function show(Role $role)
    {
        $role->load('permissions');

        ActivityLog::log(Auth::id(), 'read', 'Role', "Viewed role: {$role->name}");

        return view('roles.show', compact('role'));
    }

    /**
     * Show create role form.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles',
            'slug' => 'required|string|max:50|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => strtolower(str_replace(' ', '-', $validated['slug'])),
            'description' => $validated['description'] ?? null,
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        ActivityLog::log(Auth::id(), 'create', 'Role', "Created role: {$role->name}");

        return redirect()->route('roles.show', $role)->with('success', 'Role berhasil dibuat');
    }

    /**
     * Show edit role form.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load('permissions');
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
            'slug' => 'required|string|max:50|unique:roles,slug,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $validated['name'],
            'slug' => strtolower(str_replace(' ', '-', $validated['slug'])),
            'description' => $validated['description'] ?? null,
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        ActivityLog::log(Auth::id(), 'update', 'Role', "Updated role: {$role->name}");

        return redirect()->route('roles.show', $role)->with('success', 'Role berhasil diperbarui');
    }

    /**
     * Delete role.
     */
    public function destroy(Role $role)
    {
        // Prevent deleting roles that have users
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Role ini masih memiliki user dan tidak dapat dihapus');
        }

        $name = $role->name;
        $role->delete();

        ActivityLog::log(Auth::id(), 'delete', 'Role', "Deleted role: {$name}");

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}
