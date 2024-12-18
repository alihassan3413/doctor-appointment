<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\DoctorLeaveController;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckDoctorRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


// Super Admin Middleware

Route::middleware(['auth:sanctum', CheckAdminRole::class])
    ->prefix('/admin')
    ->group(function () {
        // Doctor Leaves
        Route::get('/leaves', [DoctorLeaveController::class, 'viewLeaves']);
        Route::put('/leave/{id}', [DoctorLeaveController::class, 'updateLeaveStatus']);  // Update leave status
        Route::put('doctors/{id}/availability', [DoctorLeaveController::class, 'drIsAvailable']);  // Update doctor availability
    });


// Doctor Middleware
Route::middleware(['auth:sanctum', CheckDoctorRole::class])
    ->prefix('/doctor')
    ->group(function () {
        Route::post('/leave', [DoctorLeaveController::class, 'requestLeave']);
        Route::get('/leaves', [DoctorLeaveController::class, 'doctorLeaves']);
});










