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
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Jangan menampilkan stack trace Laravel ke pengguna di production (Bagian 36).
        // Perilaku ini otomatis saat APP_DEBUG=false; kustomisasi pesan ditambahkan
        // bertahap seiring modul (mis. render khusus untuk ValidationException).
    })
    ->withProviders([
        App\Providers\AuthServiceProvider::class,
    ])
    ->create();
