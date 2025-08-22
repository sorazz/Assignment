<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Handler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(append: [
            \App\Http\Middleware\CheckApiKey::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e) {
            return app(Handler::class)->render(request(), $e);
        });
        $exceptions->render(function (MethodNotAllowedHttpException $e) {
            return app(Handler::class)->render(request(), $e);
        });
        $exceptions->render(function (Illuminate\Auth\AuthenticationException $e) {
            return app(Handler::class)->render(request(), $e);
        });
        $exceptions->render(function (AuthorizationException $e) {

            return app(Handler::class)->render(request(), $e);
        });
        $exceptions->render(function (ModelNotFoundException $e) {
            return app(Handler::class)->render(request(), $e);
        });

        $exceptions->render(function (UnauthorizedHttpException $e) {

            return app(Handler::class)->render(request(), $e);
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return app(Handler::class)->render(request(), $e);
        });
    })->create();
