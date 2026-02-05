<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AdminOposicionController extends Controller
{
    /**
     * Vista principal de gestión de oposiciones:
     * - Tarjetas de "Crear sección" y "Crear oposición"
     * - Listado de secciones, subsecciones y oposiciones creadas.
     */
    public function index(): View
    {
        // Todas las secciones (incluye principales y subsecciones)
        $todasSecciones = Curso::where('tipo', 'seccion')
            ->orderBy('titulo')
            ->get();

        // Secciones raíz (sin padre)
        $secciones = $todasSecciones
            ->whereNull('parent_id')
            ->values();

        // Subsecciones agrupadas por parent_id
        $subseccionesPorPadre = $todasSecciones
            ->whereNotNull('parent_id')
            ->groupBy('parent_id');

        // Oposiciones, agrupadas por parent_id
        $oposiciones = Curso::where('tipo', 'oposicion')
            ->orderBy('titulo')
            ->get()
            ->groupBy('parent_id'); // null (sin sección) o id de la sección

        return view('admin.oposiciones.index', [
            'secciones'            => $secciones,
            'subseccionesPorPadre' => $subseccionesPorPadre,
            'oposiciones'          => $oposiciones,
        ]);
    }

    /**
     * FORMULARIO: crear sección de oposiciones (nombre + sección padre opcional).
     */
    public function createSeccion(): View
    {
        // Secciones que pueden actuar como padre
        $seccionesPadre = Curso::where('tipo', 'seccion')
            ->orderBy('titulo')
            ->get();

        return view('admin.oposiciones.secciones.create', compact('seccionesPadre'));
    }

    /**
     * GUARDAR: nueva sección (tipo = seccion, con parent_id opcional).
     */
    public function storeSeccion(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'    => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:cursos,id'],
        ], [
            'titulo.required'    => 'El título de la sección es obligatorio.',
            'titulo.max'         => 'El título no puede superar los 255 caracteres.',
            'parent_id.integer'  => 'La sección padre seleccionada no es válida.',
            'parent_id.exists'   => 'La sección padre seleccionada no existe.',
        ]);

        $slugBase = Str::slug($validated['titulo']);
        $slug     = $this->generateUniqueSlug($slugBase);

        Curso::create([
            'titulo'       => $validated['titulo'],
            'slug'         => $slug,
            'resumen'      => null,
            'descripcion'  => null,
            'tipo'         => 'seccion',  // familia de oposiciones
            'parent_id'    => $validated['parent_id'] ?? null, // puede ser hija de otra sección
            'activo'       => true,
            'publicado_en' => now(),
        ]);

        return redirect()
            ->route('admin.oposiciones.index')
            ->with('status', 'Sección creada correctamente.');
    }

    /**
     * FORMULARIO: crear oposición (hija u “órfana”).
     */
    public function create(): View
    {
        // Secciones disponibles (familias)
        $secciones = Curso::where('tipo', 'seccion')
            ->orderBy('titulo')
            ->get();

        return view('admin.oposiciones.create', [
            'secciones' => $secciones,
        ]);
    }

    /**
     * GUARDAR: nueva oposición.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'      => ['required', 'string', 'max:255'],
            'resumen'     => ['nullable', 'string'],
            'descripcion' => ['nullable', 'string'],
            'parent_id'   => ['nullable', 'integer', 'exists:cursos,id'],
            'estado'      => ['required', 'in:publicar,borrador'],

            // NUEVOS CAMPOS DETALLE
            'convocatoria_anual' => ['nullable', 'string'],
            'requisitos'         => ['nullable', 'string'],
            'examen'             => ['nullable', 'string'],
            'concurso'           => ['nullable', 'string'],
            'horario_precios'    => ['nullable', 'string'],
            'equipo_docente'     => ['nullable', 'string'],
        ], [
            'titulo.required'    => 'El título de la oposición es obligatorio.',
            'titulo.max'         => 'El título no puede superar los 255 caracteres.',
            'parent_id.integer'  => 'La sección seleccionada no es válida.',
            'parent_id.exists'   => 'La sección seleccionada no existe.',
            'estado.required'    => 'Debes indicar si la oposición se publica o queda en borrador.',
            'estado.in'          => 'El estado seleccionado no es válido.',
        ]);

        $slugBase = Str::slug($validated['titulo']);
        $slug     = $this->generateUniqueSlug($slugBase);

        $activo       = $validated['estado'] === 'publicar';
        $publicado_en = $activo ? now() : null;

        Curso::create([
            'titulo'       => $validated['titulo'],
            'slug'         => $slug,
            'resumen'      => $validated['resumen'] ?? null,
            'descripcion'  => $validated['descripcion'] ?? null,
            'tipo'         => 'oposicion',
            'parent_id'    => $validated['parent_id'] ?? null,
            'activo'       => $activo,
            'publicado_en' => $publicado_en,

            // NUEVOS CAMPOS DETALLE
            'convocatoria_anual' => $validated['convocatoria_anual'] ?? null,
            'requisitos'         => $validated['requisitos'] ?? null,
            'examen'             => $validated['examen'] ?? null,
            'concurso'           => $validated['concurso'] ?? null,
            'horario_precios'    => $validated['horario_precios'] ?? null,
            'equipo_docente'     => $validated['equipo_docente'] ?? null,
        ]);

        return redirect()
            ->route('admin.oposiciones.index')
            ->with('status', 'Oposición creada correctamente.');
    }

    /**
     * FORMULARIO: editar oposición o sección.
     */
    public function edit(Curso $curso): View
    {
        // Secciones para el selector de padre (evitamos que se ponga a sí misma como padre)
        $secciones = Curso::where('tipo', 'seccion')
            ->where('id', '!=', $curso->id)
            ->orderBy('titulo')
            ->get();

        return view('admin.oposiciones.edit', [
            'curso'     => $curso,
            'secciones' => $secciones,
        ]);
    }

    /**
     * ACTUALIZAR: oposición o sección.
     */
    public function update(Request $request, Curso $curso): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'      => ['required', 'string', 'max:255'],
            'resumen'     => ['nullable', 'string'],
            'descripcion' => ['nullable', 'string'],
            'parent_id'   => ['nullable', 'integer', 'exists:cursos,id'],
            'estado'      => ['required', 'in:publicar,borrador'],
            'tipo'        => ['nullable', 'in:oposicion,seccion'],

            // NUEVOS CAMPOS DETALLE
            'convocatoria_anual' => ['nullable', 'string'],
            'requisitos'         => ['nullable', 'string'],
            'examen'             => ['nullable', 'string'],
            'concurso'           => ['nullable', 'string'],
            'horario_precios'    => ['nullable', 'string'],
            'equipo_docente'     => ['nullable', 'string'],
        ], [
            'titulo.required'    => 'El título es obligatorio.',
            'titulo.max'         => 'El título no puede superar los 255 caracteres.',
            'parent_id.integer'  => 'La sección seleccionada no es válida.',
            'parent_id.exists'   => 'La sección seleccionada no existe.',
            'estado.required'    => 'Debes indicar si se publica o queda en borrador.',
            'estado.in'          => 'El estado seleccionado no es válido.',
            'tipo.in'            => 'El tipo seleccionado no es válido.',
        ]);

        // Tipo actual (por defecto mantenemos el que ya tiene)
        $tipo = $curso->tipo;
        if (isset($validated['tipo']) && in_array($validated['tipo'], ['oposicion', 'seccion'], true)) {
            $tipo = $validated['tipo'];
        }

        $activo       = $validated['estado'] === 'publicar';
        $publicado_en = $activo ? ($curso->publicado_en ?? now()) : null;

        // Evitar que se ponga como hijo de sí mismo
        $parentId = $validated['parent_id'] ?? null;
        if ($parentId == $curso->id) {
            $parentId = null;
        }

        $curso->update([
            'titulo'       => $validated['titulo'],
            'resumen'      => $validated['resumen'] ?? null,
            'descripcion'  => $validated['descripcion'] ?? null,
            'tipo'         => $tipo,
            'parent_id'    => $parentId,
            'activo'       => $activo,
            'publicado_en' => $publicado_en,

            // NUEVOS CAMPOS DETALLE
            'convocatoria_anual' => $validated['convocatoria_anual'] ?? null,
            'requisitos'         => $validated['requisitos'] ?? null,
            'examen'             => $validated['examen'] ?? null,
            'concurso'           => $validated['concurso'] ?? null,
            'horario_precios'    => $validated['horario_precios'] ?? null,
            'equipo_docente'     => $validated['equipo_docente'] ?? null,
        ]);

        return redirect()
            ->route('admin.oposiciones.index')
            ->with('status', 'Oposición actualizada correctamente.');
    }

    /**
     * BORRAR: si es sección, sus hijos pasan a ser padres (parent_id = null).
     */
    public function destroy(Curso $curso): RedirectResponse
    {
        if ($curso->tipo === 'seccion') {
            // Todas las oposiciones y subsecciones hijas pasan a estar sin sección
            Curso::where('parent_id', $curso->id)
                ->update(['parent_id' => null]);
        }

        $curso->delete();

        return redirect()
            ->route('admin.oposiciones.index')
            ->with('status', 'Registro eliminado correctamente.');
    }

    /**
     * Genera un slug único para la tabla cursos.
     */
    protected function generateUniqueSlug(string $base): string
    {
        $slug     = $base ?: 'curso';
        $original = $slug;
        $i        = 2;

        while (Curso::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
