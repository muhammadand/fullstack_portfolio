<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\Log;


class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware run during every request to your application.
     */
    protected $middleware = [
        // Global middleware di sini
        \Illuminate\Http\Middleware\CheckResponseForModifications::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [

            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Rate limiter default API
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route Middleware (dipanggil memakai middleware('nama'))
     */
    protected $routeMiddleware = [
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'signed'     => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'   => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' =>     \App\Http\Middleware\RoleMiddleware::class,
    ];
    public function __construct(...$args)
    {
        parent::__construct(...$args);

        Log::info('Route middleware registered', [
            'routeMiddleware' => $this->routeMiddleware
        ]);
    }
}
