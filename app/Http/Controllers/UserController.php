<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display list of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%");
            });
        }

        $users = $query->with('role')->paginate(15);
        $roles = Role::all();

        ActivityLog::log(Auth::id(), 'read', 'User', 'Viewed user list');

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show create user form.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|min:6|unique:users|alpha_num',
            'phone' => 'required|string|unique:users',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Generate password
        $password = 'User@' . strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8));

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => strtolower($validated['username']),
            'phone' => $validated['phone'],
            'role_id' => $validated['role_id'],
            'password' => Hash::make($password),
        ]);

        ActivityLog::log(Auth::id(), 'create', 'User', "Created user: {$user->name}");

        return redirect()
            ->route('users.show', $user)
            ->with('success', "User berhasil dibuat. Password awal: {$password}");
    }

    /**
     * Show user details.
     */
    public function show(User $user)
    {
        ActivityLog::log(Auth::id(), 'read', 'User', "Viewed user: {$user->name}");

        return view('users.show', compact('user'));
    }

    /**
     * Show edit user form.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|min:6|unique:users,username,' . $user->id . '|alpha_num',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => strtolower($validated['username']),
            'phone' => $validated['phone'],
            'role_id' => $validated['role_id'],
            'is_active' => $request->filled('is_active'),
        ]);

        // If user is being deactivated and is currently logged in, logout
        if (!$request->filled('is_active') && Auth::id() === $user->id) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Akun Anda telah dinonaktifkan');
        }

        ActivityLog::log(Auth::id(), 'update', 'User', "Updated user: {$user->name}");

        return redirect()->route('users.show', $user)->with('success', 'User berhasil diperbarui');
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        // Prevent user from deleting themselves
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::log(Auth::id(), 'delete', 'User', "Deleted user: {$name}");

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
