<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UI\AuthWebController;
use App\Http\Controllers\UI\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/roles', [DashboardController::class, 'createRole'])->name('dashboard.create-role');
    Route::put('/roles', [DashboardController::class, 'updateRole'])->name('dashboard.update-role');
    Route::delete('/roles/delete', [DashboardController::class, 'deleteRole'])->name('dashboard.delete-role');
    Route::post('/roles/assign', [DashboardController::class, 'addRole'])->name('dashboard.add-role');
    Route::post('/roles/revoke', [DashboardController::class, 'revokeRole'])->name('dashboard.revoke-role');
    Route::post('/permissions', [DashboardController::class, 'createPermission'])->name('dashboard.create-permission');
    Route::delete('/permissions/delete', [DashboardController::class, 'deletePermission'])->name('dashboard.delete-permission');
    Route::post('/permissions/assign', [DashboardController::class, 'addPermission'])->name('dashboard.add-permission');
    Route::post('/permissions/revoke', [DashboardController::class, 'revokePermission'])->name('dashboard.revoke-permission');

    Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

    Route::get('/dashboard/properties', [PropertyController::class, 'index'])->name('dashboard.properties.index');
    Route::post('/dashboard/properties', [PropertyController::class, 'store'])->name('dashboard.properties.store');
    Route::get('/dashboard/properties/{id}', [PropertyController::class, 'show'])->name('dashboard.properties.show');
    Route::get('/dashboard/properties/{id}/edit', [PropertyController::class, 'edit'])->name('dashboard.properties.edit');
    Route::put('/dashboard/properties/{id}', [PropertyController::class, 'update'])->name('dashboard.properties.update');
    Route::delete('/dashboard/properties/{id}', [PropertyController::class, 'destroy'])->name('dashboard.properties.destroy');
});

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::post('/login', [AuthWebController::class, 'login']);
Route::post('/register', [AuthWebController::class, 'register']);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout.get');
