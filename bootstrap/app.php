<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetCurrencyMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'payment/*',
            'payment/success',
            'payment/fail',
            'payment/cancel',
            'payment/ipn',
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        ]);

        $middleware->redirectUsersTo(function (Illuminate\Http\Request $request) {
            $user = auth()->user();
            if ($user && $user->isAdmin()) {
                if ($user->isSuperAdmin()) {
                    return route('admin.admin-user.index');
                }
                return route('admin.dashboard');
            }
            return route('account.index');
        });
    })
    ->withExceptions(function (Illuminate\Foundation\Configuration\Exceptions $exceptions) {
        //
    })
    ->create()
    ->usePublicPath(base_path());
