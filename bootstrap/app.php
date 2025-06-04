<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })

    ->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
       'api/*',
        
        // If using Stripe webhooks
        'stripe/webhook',
        
        // If you have other external services calling your backend
        'webhook/*',
        
        // If your frontend is on a different domain (e.g., Next.js on port 3000)
        'http://localhost:3000/*',
        
        // Any other specific routes that don't need CSRF
        'mobile-app/*',
    ]);
})

   

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
