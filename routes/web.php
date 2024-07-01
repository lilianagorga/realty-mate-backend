<?php

use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
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

    Route::get('/dashboard/roles-and-permissions', [DashboardController::class, 'rolesAndPermissions'])->name('dashboard.roles-permissions');

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

    Route::resource('/dashboard/properties', PropertyController::class)->names([
        'index' => 'dashboard.properties.index',
        'store' => 'dashboard.properties.store',
        'show' => 'dashboard.properties.show',
        'edit' => 'dashboard.properties.edit',
        'update' => 'dashboard.properties.update',
        'destroy' => 'dashboard.properties.destroy'
    ])->except('create');

    Route::resource('/dashboard/teams', TeamController::class)->names([
        'index' => 'dashboard.teams.index',
        'store' => 'dashboard.teams.store',
        'create' => 'dashboard.teams.create',
        'show' => 'dashboard.teams.show',
        'edit' => 'dashboard.teams.edit',
        'update' => 'dashboard.teams.update',
        'destroy' => 'dashboard.teams.destroy'
    ]);

    Route::resource('/dashboard/prices', PriceController::class)->names([
        'index' => 'dashboard.prices.index',
        'store' => 'dashboard.prices.store',
        'create' => 'dashboard.prices.create',
        'show' => 'dashboard.prices.show',
        'edit' => 'dashboard.prices.edit',
        'update' => 'dashboard.prices.update',
        'destroy' => 'dashboard.prices.destroy'
    ]);

    Route::resource('/dashboard/testimonials', TestimonialController::class)->names([
        'index' => 'dashboard.testimonials.index',
        'store' => 'dashboard.testimonials.store',
        'create' => 'dashboard.testimonials.create',
        'show' => 'dashboard.testimonials.show',
        'edit' => 'dashboard.testimonials.edit',
        'update' => 'dashboard.testimonials.update',
        'destroy' => 'dashboard.testimonials.destroy'
    ]);

    Route::resource('/dashboard/partners', PartnerController::class)->names([
        'index' => 'dashboard.partners.index',
        'store' => 'dashboard.partners.store',
        'create' => 'dashboard.partners.create',
        'show' => 'dashboard.partners.show',
        'edit' => 'dashboard.partners.edit',
        'update' => 'dashboard.partners.update',
        'destroy' => 'dashboard.partners.destroy'
    ]);
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

Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
