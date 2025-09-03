<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\InfluencerMiddleware;
use App\Http\Middleware\BusinessMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\InfluencerVideoMiddleware;
use App\Http\Middleware\InfluencerOtpMiddleware;
use App\Http\Middleware\BusinessVideoMiddleware;
use App\Http\Middleware\BusinessOtpMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'influencer'=>InfluencerMiddleware::class,
            'business'=>BusinessMiddleware::class,
            'admin'=>AdminMiddleware::class,
            'influencervideo'=>InfluencerVideoMiddleware::class,
            'influencerotp'=>InfluencerOtpMiddleware::class,
            'businessvideo'=>BusinessVideoMiddleware::class,
            'businessotp'=>BusinessOtpMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
