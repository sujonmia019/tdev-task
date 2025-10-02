<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\VerifyUserMiddleware;
use App\Http\Middleware\AuthenticateMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfAuthenticatedMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/auth.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest'       => RedirectIfAuthenticatedMiddleware::class,
            'auth.check'  => AuthenticateMiddleware::class,
            'adminRole'   => AdminMiddleware::class,
            'userRole'    => UserMiddleware::class,
            'auth.verify' => VerifyUserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token',
            ], 401);
        });
    })->create();
