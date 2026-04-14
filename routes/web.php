<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransportAllowanceController;
use App\Http\Controllers\TransportAllowanceSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect to login or dashboard
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/captcha/generate', [AuthController::class, 'generateCaptcha'])->name('captcha.generate');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Authenticated Routes
Route::middleware('auth', 'check.if.user.is.active')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::middleware('permission:user.view')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });
    Route::middleware('permission:user.create')->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });
    Route::middleware('permission:user.edit')->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });
    Route::middleware('permission:user.delete')->group(function () {
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    // Role Management
    Route::middleware('permission:role.view')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    });
    Route::middleware('permission:role.create')->group(function () {
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    });
    Route::middleware('permission:role.edit')->group(function () {
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });
    Route::middleware('permission:role.delete')->group(function () {
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // Employee Management
    Route::middleware('permission:employee.view')->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/export-excel', [EmployeeController::class, 'exportExcel'])->name('employees.export-excel');
        Route::get('/employees/export-pdf', [EmployeeController::class, 'exportPdf'])->name('employees.export-pdf');
    });

    Route::middleware('permission:employee.create')->group(function () {
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    });

    Route::middleware('permission:employee.view')->group(function () {
        Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    });

    Route::middleware('permission:employee.edit')->group(function () {
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    });

    Route::middleware('permission:employee.delete')->group(function () {
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });

    // Transport Allowance
    Route::middleware('permission:transport-allowance.view')->group(function () {
        Route::get('/transport-allowances', [TransportAllowanceController::class, 'index'])->name('transport-allowances.index');
        Route::get('/transport-allowances/{allowance}', [TransportAllowanceController::class, 'show'])->name('transport-allowances.show');
    });
    Route::middleware('permission:transport-allowance.create')->group(function () {
        Route::get('/transport-allowances/create', [TransportAllowanceController::class, 'create'])->name('transport-allowances.create');
        Route::post('/transport-allowances', [TransportAllowanceController::class, 'store'])->name('transport-allowances.store');
    });
    Route::middleware('permission:transport-allowance.edit')->group(function () {
        Route::get('/transport-allowances/{allowance}/edit', [TransportAllowanceController::class, 'edit'])->name('transport-allowances.edit');
        Route::put('/transport-allowances/{allowance}', [TransportAllowanceController::class, 'update'])->name('transport-allowances.update');
    });
    Route::middleware('permission:transport-allowance.delete')->group(function () {
        Route::delete('/transport-allowances/{allowance}', [TransportAllowanceController::class, 'destroy'])->name('transport-allowances.destroy');
    });

    // Transport Allowance Settings
    Route::middleware('permission:transport-settings.view')->group(function () {
        Route::get('/transport-settings', [TransportAllowanceSettingController::class, 'index'])->name('transport-settings.index');
    });
    Route::middleware('permission:transport-settings.edit')->group(function () {
        Route::get('/transport-settings/create', [TransportAllowanceSettingController::class, 'create'])->name('transport-settings.create');
        Route::post('/transport-settings', [TransportAllowanceSettingController::class, 'store'])->name('transport-settings.store');
    });

    // Location APIs (for cascading selects)
    Route::get('/api/districts/{province}', [LocationController::class, 'getDistricts']);
    Route::get('/api/sub-districts/{district}', [LocationController::class, 'getSubDistricts']);
    Route::get('/api/search-sub-districts', [LocationController::class, 'searchSubDistricts']);
    Route::get('/api/location-from-sub-district/{id}', [LocationController::class, 'getLocationFromSubDistrict']);

    // Activity Logs
    Route::middleware('permission:activity-log.view')->group(function () {
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});
