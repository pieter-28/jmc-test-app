<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles - use firstOrCreate to avoid duplicates
        $superadmin = Role::firstOrCreate(['slug' => 'superadmin'], ['name' => 'Superadmin', 'description' => 'Super administrator with full access']);

        $managerHrd = Role::firstOrCreate(['slug' => 'manager-hrd'], ['name' => 'Manager HRD', 'description' => 'HR Manager with limited access']);

        $adminHrd = Role::firstOrCreate(['slug' => 'admin-hrd'], ['name' => 'Admin HRD', 'description' => 'HR Administrator with employee management access']);

        // Create permissions
        $permissions = [
            // Login/Logout
            ['name' => 'Login', 'slug' => 'auth.login'],
            ['name' => 'Logout', 'slug' => 'auth.logout'],

            // Role Management
            ['name' => 'View Roles', 'slug' => 'role.view'],
            ['name' => 'Create Role', 'slug' => 'role.create'],
            ['name' => 'Edit Role', 'slug' => 'role.edit'],
            ['name' => 'Delete Role', 'slug' => 'role.delete'],

            // User Management
            ['name' => 'View Users', 'slug' => 'user.view'],
            ['name' => 'Create User', 'slug' => 'user.create'],
            ['name' => 'Edit User', 'slug' => 'user.edit'],
            ['name' => 'Delete User', 'slug' => 'user.delete'],
            ['name' => 'Edit Own User', 'slug' => 'user.edit_own'],

            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'dashboard.view'],

            // Employee Management
            ['name' => 'View Employees', 'slug' => 'employee.view'],
            ['name' => 'Create Employee', 'slug' => 'employee.create'],
            ['name' => 'Edit Employee', 'slug' => 'employee.edit'],
            ['name' => 'Delete Employee', 'slug' => 'employee.delete'],

            // Transport Allowance
            ['name' => 'View Transport Allowance', 'slug' => 'transport-allowance.view'],
            ['name' => 'Create Transport Allowance', 'slug' => 'transport-allowance.create'],
            ['name' => 'Edit Transport Allowance', 'slug' => 'transport-allowance.edit'],
            ['name' => 'Delete Transport Allowance', 'slug' => 'transport-allowance.delete'],

            // Transport Settings
            ['name' => 'View Transport Settings', 'slug' => 'transport-settings.view'],
            ['name' => 'Edit Transport Settings', 'slug' => 'transport-settings.edit'],

            // Activity Log
            ['name' => 'View Activity Logs', 'slug' => 'activity-log.view'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['slug' => $permission['slug']], ['name' => $permission['name']]);
        }

        // Assign permissions to roles
        // Superadmin gets all permissions
        $superadmin->permissions()->sync(Permission::pluck('id')->toArray());

        // Manager HRD permissions
        $managerHrdPermissions = Permission::whereIn('slug', ['auth.login', 'auth.logout', 'dashboard.view', 'employee.view', 'transport-allowance.view', 'user.view', 'user.edit_own'])->pluck('id');
        $managerHrd->permissions()->sync($managerHrdPermissions);

        // Admin HRD permissions
        $adminHrdPermissions = Permission::whereIn('slug', ['auth.login', 'auth.logout', 'dashboard.view', 'employee.view', 'employee.create', 'employee.edit', 'employee.delete', 'transport-allowance.view', 'transport-settings.view', 'transport-settings.edit', 'user.view', 'user.edit_own'])->pluck('id');
        $adminHrd->permissions()->sync($adminHrdPermissions);
    }
}
