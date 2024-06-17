<?php

use App\Http\Controllers\UI\AuthWebController;
use App\Http\Controllers\UI\DashboardWebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardWebController::class, 'dashboard'])->name('dashboard');
    Route::get('/roles', [DashboardWebController::class, 'createRole'])->name('dashboard.create-role');
    Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');
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
