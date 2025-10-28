<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware custom
        $middleware->alias([
            'RoleCheck' => \App\Http\Middleware\RoleCheck::class,
        ]);

        // Contoh menambahkan middleware global di stack
        // $middleware->append(\App\Http\Middleware\SomeGlobalMiddleware::class);

        // Contoh menambahkan ke group API
        // $middleware->api(append: [\App\Http\Middleware\ApiCheck::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom exception handling
        // $exceptions->renderable(function (Throwable $e, $request) {
        //     if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        //         return response()->json(['message' => 'Not Found'], 404);
        //     }
        // });
    })
    ->create();
