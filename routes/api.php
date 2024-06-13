<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PropertyController;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::post('/roles', [DashboardController::class, 'createRole']);
    Route::put('/roles', [DashboardController::class, 'updateRole']);
    Route::delete('/roles/delete', [DashboardController::class, 'deleteRole']);
    Route::post('/roles/assign', [DashboardController::class, 'addRole']);
    Route::post('/roles/revoke', [DashboardController::class, 'revokeRole']);
    Route::post('/permissions', [DashboardController::class, 'createPermission']);
    Route::delete('/permissions/delete', [DashboardController::class, 'deletePermission']);
    Route::post('/permissions/assign', [DashboardController::class, 'addPermission']);
    Route::post('/permissions/revoke', [DashboardController::class, 'revokePermission']);

    Route::get('/properties', [PropertyController::class, 'index']);
    Route::post('/properties', [PropertyController::class, 'store']);
    Route::get('/properties/{id}', [PropertyController::class, 'show']);
    Route::put('/properties/{id}', [PropertyController::class, 'update']);
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);

    Route::get('/teams', [TeamController::class, 'index']);

    Route::apiResource('users', UserController::class)->except('store');

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::post('/user/register', [AuthController::class, 'register']);
Route::post('/user/login', [AuthController::class, 'login']);
