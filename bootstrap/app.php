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
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Déclaration de tes alias de middleware existants
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // 2. Évite que Laravel ou le serveur ne paniquent sur le CSRF 
        // si la méthode est altérée pendant le téléversement de la photo
        $middleware->validateCsrfTokens(except: [
            'register/*/save',
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();