<?php

use App\Http\Middleware\AdminAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        // admin: __DIR__ . '/../routes/admin.php',
        // backend: __DIR__ . '/../routes/backend.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Register the custom admin routes file
            Route::middleware([
                'web',  // Enables sessions, CSRF, etc.
                'auth', // Requires authentication
                'admin', // Custom admin check
            ])
                ->prefix('admin') // All routes prefixed with /admin
                // ->name('admin.') // All route names prefixed with 'admin.'
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => AdminAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
