## Copilot / AI agent instructions (es)

Resumen rápido
- Proyecto: Laravel (PHP) + Vite (JS/CSS). Código ubicado en la raíz del repo; archivos públicos en `public/`.
- Entorno local habitual: XAMPP (el repo está en `htdocs` en este entorno). Alternativa: `php artisan serve`.

Dónde mirar primero
- Rutas: `routes/web.php` — muchas rutas web y los nombres de ruta (ej. `matricula.enviar`).
- Controladores: `app/Http/Controllers/` — lógica de las peticiones. Buscar el controlador que maneje la ruta por nombre o por path.
- Vistas Blade: `resources/views/` (p. ej. `resources/views/matriculate/index.blade.php`).
- Modelos: `app/Models/` (ej. `User.php`).
- Migrations/Seeds: `database/migrations/`, `database/seeders/`.

Comandos útiles (Windows / XAMPP)
- Instalar dependencias PHP: `composer install`.
- Instalar dependencias JS: `npm install`.
- Desarrollo de assets (Vite): `npm run dev` (modo watch) o `npm run build` (producción).
- Tests (phpunit): usar `vendor\\bin\\phpunit` o en Windows el `vendor\\bin\\phpunit.bat` según presente en `vendor/`.
- Artisan comunes: `php artisan migrate`, `php artisan db:seed`, `php artisan storage:link`.
- Si se usa XAMPP, el proyecto suele servirse desde `http://localhost/<carpeta>/public`.

Patrones y convenciones del repo (detectables)
- Formularios Blade: se usan `@csrf`, `old('field')`, `@error('field')` y HTML5 attributes (pattern, required). Ejemplo: `resources/views/matriculate/index.blade.php`.
- Subida de archivos: los formularios usan `enctype="multipart/form-data"` y validación/guardado debe manejarse en el controlador.
- Estructura CSS/JS: fuentes en `resources/css` y `resources/js`; compilados en `public/` a través de Vite (`vite.config.js` existe).
- Internationalización/locales: no se observan archivos `lang/` explícitos; las cadenas están en español en las vistas.

Cómo localizar el handler de una ruta concreta
1. Abrir `routes/web.php` y buscar el nombre de ruta (ej. `matricula.enviar`).
2. Si no está, correr `php artisan route:list` y filtrar por la columna `Name` para encontrar el controlador y método.

Errores y validación
- Las vistas muestran errores con `@error` y `$errors->any()`; la validación se espera en controladores o Form Requests (`app/Http/Requests/`).
- Para cambios de validación: modificar el controller o agregar/editar un Form Request y mantener mensajes claros en la vista.

Notas de testing y CI
- Archivo `phpunit.xml` existe; los tests están en `tests/`. Ejecutar unit/feature con phpunit localmente.

Consejos para PRs y cambios de UI
- Cuando toques vistas Blade, revisa los assets en `resources/` y ejecuta `npm run dev` para ver cambios.
- Si añades rutas, actualiza `routes/web.php` y añade tests básicos en `tests/Feature` que cubran la ruta (status 200 y contenido esperado).

Ejemplos concretos en este repo
- Formulario de matrícula: `resources/views/matriculate/index.blade.php` — contiene select cargado por JS (`data-initial`), subida de archivos y uso de `old()`/`@error`.
- Busca `tarifa` o `curso_matriculacion` en vistas/controladores para entender la lógica de tarifas y carga de cursos.

Si necesitas más contexto
- Pregunta por: configuración de la base de datos en `.env`, uso real de XAMPP vs `artisan serve`, o rutas específicas que quieras que localice y comente.

Fin
Por favor revisa este borrador y dime qué detalles quieres que añada o modifique (idioma, comandos extra, políticas de commit/PRs, estilo de código).
