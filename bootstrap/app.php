<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (){
            Route::middleware(['web'])
                ->prefix('auth')
                ->group(base_path('routes/auth.php'));
            //Admin route
            Route::middleware(['web','auth','auth.session','isAdmin'])
                ->prefix('modacore')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
            //User route
            Route::middleware(['web','auth','auth.session'])
                ->prefix('user')
                ->name('user.')
                ->group(base_path('routes/user.php'));
            //Affiliate route
            Route::middleware(['web','auth','auth.session','isAffiliate'])
                ->prefix('affiliate')
                ->name('affiliate.')
                ->group(base_path('routes/affiliate.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\AdminMiddleware::class,
            'isAffiliate' => \App\Http\Middleware\AffiliateMiddleware::class,
            'hasPermission'=>\App\Http\Middleware\PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
