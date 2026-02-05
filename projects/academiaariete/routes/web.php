<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Services\JwtService;

// MODELOS
use App\Models\Promocion;

// MATRÍCULA
use App\Http\Controllers\MatriculaController;

// NOTICIAS
use App\Http\Controllers\NoticiaController;

// CONTACTO
use App\Http\Controllers\ContactoController;

// TRABAJA CON NOSOTROS
use App\Http\Controllers\TrabajoController;

// PANEL ADMIN
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminNoticiaController;
use App\Http\Controllers\Admin\AdminCategoriaController;
use App\Http\Controllers\Admin\AdminOposicionController;
use App\Http\Controllers\Admin\AdminPromocionController;
use App\Http\Controllers\ProfileController;

// =======================
// PÁGINA DE INICIO
// =======================
// Ahora usamos un callback para poder pasar las promociones a la vista.
Route::get('/', function () {
    $promociones = Promocion::where('activo', true)
        ->orderBy('orden')
        ->orderByDesc('created_at')
        ->get();

    return view('home.index', compact('promociones'));
})->name('inicio');

// =======================
// CARPETA LEGAL
// =======================

Route::view('/aviso-legal', 'legal.aviso-legal')
    ->name('aviso-legal');

Route::view('/politica-de-privacidad', 'legal.politica-privacidad')
    ->name('politica-de-privacidad');

Route::view('/politica-cookies', 'legal.politica-cookies')
    ->name('politica-cookies');

Route::view('/consentimiento-lopd', 'legal.consentimiento-lopd')
    ->name('consentimiento-lopd');

// Términos y condiciones generales
Route::view('/terminos-y-condiciones', 'contacto.terminos-y-condiciones')
    ->name('terminos-y-condiciones');

// =======================
// MATRÍCULA
// =======================

Route::get('/matriculate', [MatriculaController::class, 'index'])
    ->name('matriculate');

Route::post('/matriculate', [MatriculaController::class, 'enviar'])
    ->name('matricula.enviar');

// =======================
// CONTACTO
// =======================

Route::view('/contactar', 'contacto.index')
    ->name('contactar.index');

Route::get('/contacto', [ContactoController::class, 'create'])
    ->name('contacto');

Route::post('/contacto', [ContactoController::class, 'enviar'])
    ->name('contacto.enviar');

Route::view('/contacto/terminos', 'contacto.terminos-y-condiciones')
    ->name('contacto.terminos');

// =======================
// TRABAJA CON NOSOTROS
// =======================

Route::get('/trabaja-con-nosotros', [TrabajoController::class, 'create'])
    ->name('trabaja.index');

Route::post('/trabaja-con-nosotros', [TrabajoController::class, 'store'])
    ->name('trabajo.enviar');

// =======================
// NOTICIAS PÚBLICAS
// =======================

Route::get('/noticias', [NoticiaController::class, 'index'])
    ->name('noticias.index');

Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])
    ->name('noticias.show');

// =======================
// OPOSICIONES PÚBLICAS
// =======================

// Índice de todas las secciones/oposiciones
Route::get('/oposiciones', [\App\Http\Controllers\OposicionController::class, 'index'])
    ->name('oposiciones.index');

// Vista pública de una sección con sus oposiciones hijas
Route::get('/oposiciones/seccion/{curso}', [\App\Http\Controllers\OposicionController::class, 'showSeccion'])
    ->name('oposiciones.seccion.show');

// Vista pública de una oposición concreta
Route::get('/oposiciones/{curso}', [\App\Http\Controllers\OposicionController::class, 'show'])
    ->name('oposiciones.show');

// =======================
// PANEL ADMIN (SOLO ROL ADMIN → 403 si no lo es)
// =======================
Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Panel principal
        Route::get('/panel', [PanelController::class, 'index'])
            ->name('panel');

        // =======================
        // GESTIÓN DE USUARIOS
        // =======================
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [AdminUserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [AdminUserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

        // Vaciar contraseña
        Route::post('/users/{user}/clear-password', [AdminUserController::class, 'clearPassword'])
            ->name('users.clear-password');

        // =======================
        // GESTIÓN DE OPOSICIONES
        // =======================

        Route::get('/oposiciones', [AdminOposicionController::class, 'index'])
            ->name('oposiciones.index');

        Route::get('/oposiciones/secciones/crear', [AdminOposicionController::class, 'createSeccion'])
            ->name('oposiciones.secciones.create');

        Route::post('/oposiciones/secciones', [AdminOposicionController::class, 'storeSeccion'])
            ->name('oposiciones.secciones.store');

        Route::get('/oposiciones/crear', [AdminOposicionController::class, 'create'])
            ->name('oposiciones.create');

        Route::post('/oposiciones', [AdminOposicionController::class, 'store'])
            ->name('oposiciones.store');

        Route::get('/oposiciones/{curso}/editar', [AdminOposicionController::class, 'edit'])
            ->name('oposiciones.edit');

        Route::put('/oposiciones/{curso}', [AdminOposicionController::class, 'update'])
            ->name('oposiciones.update');

        Route::delete('/oposiciones/{curso}', [AdminOposicionController::class, 'destroy'])
            ->name('oposiciones.destroy');

        // =======================
        // GESTIÓN DE NOTICIAS
        // =======================
        Route::get('/noticias', [AdminNoticiaController::class, 'index'])
            ->name('noticias.index');

        Route::get('/noticias/crear', [AdminNoticiaController::class, 'create'])
            ->name('noticias.create');

        Route::post('/noticias', [AdminNoticiaController::class, 'store'])
            ->name('noticias.store');

        Route::get('/noticias/{noticia}/editar', [AdminNoticiaController::class, 'edit'])
            ->name('noticias.edit');

        Route::put('/noticias/{noticia}', [AdminNoticiaController::class, 'update'])
            ->name('noticias.update');

        Route::delete('/noticias/{noticia}', [AdminNoticiaController::class, 'destroy'])
            ->name('noticias.destroy');

        // =======================
        // GESTIÓN DE CATEGORÍAS
        // =======================
        Route::delete('/categorias/{categoria}', [AdminCategoriaController::class, 'destroy'])
            ->name('categorias.destroy');

        // =======================
        // GESTIÓN DE PROMOCIONES
        // =======================
        Route::get('/promociones', [AdminPromocionController::class, 'index'])
            ->name('promociones.index');

        Route::get('/promociones/crear', [AdminPromocionController::class, 'create'])
            ->name('promociones.create');

        Route::post('/promociones', [AdminPromocionController::class, 'store'])
            ->name('promociones.store');

        Route::get('/promociones/{promocion}/editar', [AdminPromocionController::class, 'edit'])
            ->name('promociones.edit');

        Route::put('/promociones/{promocion}', [AdminPromocionController::class, 'update'])
            ->name('promociones.update');

        Route::delete('/promociones/{promocion}', [AdminPromocionController::class, 'destroy'])
            ->name('promociones.destroy');
    });

// =======================
// PERFIL DE USUARIO (CUALQUIER AUTENTICADO)
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])
        ->name('perfil.edit');

    Route::put('/perfil', [ProfileController::class, 'update'])
        ->name('perfil.update');

    Route::delete('/perfil', [ProfileController::class, 'destroy'])
        ->name('perfil.destroy');
});

// =======================
// ACERCA DE
// =======================
Route::view('/acerca-de', 'acerca-de')
    ->name('acerca-de');

// =======================
// RUTAS DE PRUEBA ERRORES
// =======================
Route::get('/test-404', function () {
    abort(404);
});

Route::get('/test-500', function () {
    abort(500);
});

// =======================
// RUTA DE PRUEBA JWT
// =======================
Route::get('/jwt-debug', function (Request $request) {

    // Leer Authorization: Bearer <token>
    $authHeader = $request->header('Authorization', '');
    $token = null;

    if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
        $token = substr($authHeader, 7);
    }

    // Decodificar con nuestro servicio
    $payload = JwtService::decode($token);

    return response()->json([
        'jwt_raw'     => $token,
        'jwt_payload' => $payload,
    ]);
})->name('jwt.debug');

// =======================
// RUTAS DE AUTENTICACIÓN
// =======================
require __DIR__ . '/auth.php';
