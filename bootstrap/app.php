<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\SetupSSLForSocialite;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cekRole' => CheckRole::class,
        ]);
        // Add global middleware for SSL setup
        $middleware->append(SetupSSLForSocialite::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
