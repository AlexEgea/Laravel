<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Spatie\Permission\Exceptions\UnauthorizedException as SpatieUnauthorizedException;
// 👈 OJO: no importamos Throwable, usamos \Throwable directamente

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias personalizados de middlewares (Spatie Permission + Admin)
        $middleware->alias([
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            // Si al final usas CheckAdmin, este alias ya está listo
            'admin.only'         => \App\Http\Middleware\CheckAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 1) Errores HTTP típicos (404, 403, 429, 503, etc.)
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            $status = $e->getStatusCode();

            // Si la petición espera JSON (API/AJAX), dejamos que Laravel responda como siempre.
            if ($request->expectsJson()) {
                return null;
            }

            // Si tienes una vista resources/views/errores/404.blade.php, 403.blade.php, etc.
            if (view()->exists("errores.$status")) {
                return response()->view("errores.$status", [
                    'exception' => $e,
                ], $status);
            }

            // Si no hay vista personalizada, que Laravel haga lo suyo
            return null;
        });

        // 2) Errores de permisos de Spatie (role/permission) → 403
        $exceptions->render(function (SpatieUnauthorizedException $e, Request $request) {
            // Para API/AJAX devolvemos JSON con 403
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'Acceso no autorizado',
                ], 403);
            }

            // Si existe la vista errores/403.blade.php, la usamos
            if (view()->exists('errores.403')) {
                return response()->view('errores.403', [
                    'exception' => $e,
                ], 403);
            }

            // Fallback: abort 403 normal
            abort(403, 'Acceso no autorizado');
        });

        // 3) Errores genéricos → 500 personalizada SOLO cuando:
        //    - NO es validación
        //    - NO es HttpResponseException (redirecciones con errores)
        //    - NO es petición JSON
        $exceptions->render(function (\Throwable $e, Request $request) {
            // a) Dejar en paz todo lo que sea validación/redirecciones
            if ($e instanceof ValidationException || $e instanceof HttpResponseException) {
                return null; // Laravel ya se encarga (redirección con $errors)
            }

            // b) Si la petición espera JSON, no tocamos nada
            if ($request->expectsJson()) {
                return null;
            }

            // c) En modo debug, queremos ver el error de Laravel (Whoops)
            if (config('app.debug')) {
                return null;
            }

            // d) En producción, si tienes una vista errores/500.blade.php, la usamos
            if (view()->exists('errores.500')) {
                return response()->view('errores.500', [
                    'exception' => $e,
                ], 500);
            }

            // e) Si no hay vista personalizada, Laravel hace lo que haría por defecto
            return null;
        });
    })
    ->create();
