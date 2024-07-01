<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PdfGuideController;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('properties', PropertyController::class)->except('edit');
    Route::apiResource('teams', TeamController::class)->except(['create', 'edit', 'index']);
    Route::apiResource('prices', PriceController::class)->except(['create', 'edit', 'index']);


    Route::apiResource('testimonials', TestimonialController::class)->except(['create', 'edit', 'index']);
    Route::apiResource('partners', PartnerController::class)->except(['create', 'edit', 'index']);

    Route::apiResource('users', UserController::class)->except('store');

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/send-guide', [PdfGuideController::class, 'sendGuide']);
    Route::post('/contact', [ContactController::class, 'sendContactEmail']);
});

Route::get('/partners', [PartnerController::class, 'index']);
Route::get('/prices', [PriceController::class, 'index']);
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);

Route::post('/user/register', [AuthController::class, 'register']);
Route::post('/user/login', [AuthController::class, 'login']);

Route::get('/footer-links', [FooterController::class, 'index']);
