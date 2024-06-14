<?php

//use App\Http\Controllers\UI\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UI\HomeController;
use App\Http\Controllers\UI\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::middleware('auth')->group(function () {
//    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
//    Route::get('/roles', [DashboardController::class, 'createRole'])->name('dashboard.create-role');
//    Route::post('/logout', function () {
//        Auth::logout();
//        return redirect('/login');
//    })->name('logout');
//});
//
//Route::get('/login', function () {
//    return view('auth.login');
//})->name('login');
//
//Route::post('/login', [AuthController::class, 'login']);
//
//Route::get('/register', function () {
//    return view('auth.register');
//})->name('register');
//
//Route::post('/register', [AuthController::class, 'register']);
//
//Route::get('/logout', function () {
//    Auth::logout();
//    return redirect('/login');
//})->name('logout.get');
