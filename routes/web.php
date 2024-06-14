<?php

use App\Http\Controllers\UI\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/roles', [DashboardController::class, 'createRole'])->name('dashboard.create-role');
//    Route::post('/logout', function () {
//        Auth::logout();
//        return redirect('/login');
//    })->name('logout');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

//Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout.get');
