<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Support\Seo;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            $status = $response->getStatusCode();

            if ($request->expectsJson()) {
                return $response;
            }

            if ($status === 419) {
                Inertia::flash('quote', ['status' => 'expired']);

                return back();
            }

            if (config('app.debug') && $status >= 500) {
                return $response;
            }

            if (! $request->isMethod('GET') && $status >= 500) {
                Inertia::flash('quote', ['status' => 'error']);

                return back();
            }

            if (! in_array($status, [403, 404, 500, 503])) {
                return $response;
            }

            return Inertia::render('Error', [
                'status' => $status,
                'seo' => Seo::make($status === 404 ? 'Página no encontrada' : 'Error'),
            ])
                ->toResponse($request)
                ->setStatusCode($status);
        });
    })->create();
