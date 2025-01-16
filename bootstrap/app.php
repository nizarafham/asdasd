<?php

use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MentorMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Cors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'userMiddleware' => UserMiddleware::class,
            'adminMiddleware' => AdminMiddleware::class,
            'mentorMiddleware' => MentorMiddleware::class,
        ]);
        $middleware->prepend(Cors::class);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
