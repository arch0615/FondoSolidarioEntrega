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
            'role' => \App\Http\Middleware\CheckUserRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            if ($e instanceof \Illuminate\Validation\ValidationException ||
                $e instanceof \Illuminate\Auth\AuthenticationException) {
                return null;
            }

            $message = match (true) {
                $e instanceof \Illuminate\Database\QueryException
                    => 'Error de base de datos. Por favor intente nuevamente.',
                $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
                    => 'El registro solicitado no fue encontrado.',
                $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
                    => 'La página solicitada no existe.',
                $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
                    => 'Método de solicitud no permitido.',
                $e instanceof \Illuminate\Auth\Access\AuthorizationException
                    => 'No tiene permisos para realizar esta acción.',
                default
                    => 'Ha ocurrido un error inesperado. Por favor intente nuevamente.',
            };

            $previous = url()->previous();
            $current  = url()->current();
            $fallback = route('login');

            $redirectTo = ($previous && $previous !== $current) ? $previous : $fallback;

            return redirect($redirectTo)->with('toast_error', $message);
        });
    })->create();