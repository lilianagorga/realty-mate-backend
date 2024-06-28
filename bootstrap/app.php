<?php

use App\Console\Commands\CreateTeam;
use App\Console\Commands\CreateTestimonials;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Console\Commands\CreateAdmin;
use App\Console\Commands\CreatePricesCommand;
use App\Console\Commands\CreatePartnersCommand;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'login',
            'register',
            'logout'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withCommands([
        CreateAdmin::class,
        CreateTeam::class,
        CreatePricesCommand::class,
        CreateTestimonials::class,
        CreatePartnersCommand::class,
    ])->create();
