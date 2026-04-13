<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\EmployeeApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\PositionApiController;
use App\Http\Controllers\Api\DepartmentApiController;

// Location API (auth required but not Sanctum)
Route::middleware('auth')->group(function () {
    Route::get('/districts/{province}', [LocationController::class, 'getDistricts']);
    Route::get('/sub-districts/{district}', [LocationController::class, 'getSubDistricts']);
    Route::get('/search-sub-districts', [LocationController::class, 'searchSubDistricts']);
    Route::get('/location-from-sub-district/{id}', [LocationController::class, 'getLocationFromSubDistrict']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Employee API
    Route::apiResource('employees', EmployeeApiController::class);

    // User API (for admin)
    Route::apiResource('users', UserApiController::class)->middleware('permission:user.view');

    // Position API
    Route::apiResource('positions', PositionApiController::class)->only(['index', 'show']);

    // Department API
    Route::apiResource('departments', DepartmentApiController::class)->only(['index', 'show']);
});
