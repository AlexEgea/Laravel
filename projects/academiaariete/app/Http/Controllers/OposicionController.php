<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\View\View;

class OposicionController extends Controller
{
    /**
     * Índice público de oposiciones:
     * - lista secciones raíz (familias principales)
     * - oposiciones sin sección (principales).
     */
    public function index(): View
    {
        // Secciones raíz (sin parent_id), activas
        $secciones = Curso::where('tipo', 'seccion')
            ->whereNull('parent_id')
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        // Oposiciones sin sección, activas
        $oposicionesSueltas = Curso::where('tipo', 'oposicion')
            ->whereNull('parent_id')
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        return view('oposiciones.index', [
            'secciones'          => $secciones,
            'oposicionesSueltas' => $oposicionesSueltas,
        ]);
    }

    /**
     * Vista pública de una sección:
     * - muestra subsecciones hijas directas (tipo = seccion, parent_id = id de esta sección)
     * - muestra oposiciones hijas DIRECTAS activas (tipo = oposicion, parent_id = id de esta sección).
     *
     * Ejemplo:
     *  Enseñanza (id 17)
     *    - Maestro (id 47, seccion)
     *    - Profesor (id 49, seccion)
     *    - [aquí podría haber oposiciones directas con parent_id = 17]
     *
     * En la página de Enseñanza se verán:
     *  - Secciones: Maestro, Profesor
     *  - Oposiciones: SOLO las que tengan parent_id = 17
     *
     * Las oposiciones como "Maestro de primaria" (parent_id = 47)
     * solo se verán en la página de la sección Maestro.
     */
    public function showSeccion(Curso $curso): View
    {
        $seccion = $curso;

        // Debe ser una sección
        abort_unless($seccion->tipo === 'seccion', 404);

        // SUBSECCIONES DIRECTAS: tipo seccion, hijas de esta sección
        $subsecciones = Curso::where('tipo', 'seccion')
            ->where('parent_id', $seccion->id)
            ->orderBy('titulo')
            ->get();

        // OPOSICIONES DIRECTAS: tipo oposicion, hijas de esta sección y activas
        $oposiciones = Curso::where('tipo', 'oposicion')
            ->where('parent_id', $seccion->id)
            ->where('activo', true)
            ->orderBy('titulo')
            ->get();

        return view('oposiciones.seccion', [
            'seccion'      => $seccion,
            'subsecciones' => $subsecciones,
            'oposiciones'  => $oposiciones,
        ]);
    }

    /**
     * Vista pública de una oposición concreta.
     */
    public function show(Curso $curso): View
    {
        // Debe ser una oposición, no una sección
        abort_unless($curso->tipo === 'oposicion', 404);

        $seccion = null;

        if ($curso->parent_id) {
            $seccion = Curso::find($curso->parent_id);
        }

        return view('oposiciones.show', [
            'oposicion' => $curso,
            'seccion'   => $seccion,
        ]);
    }
}
