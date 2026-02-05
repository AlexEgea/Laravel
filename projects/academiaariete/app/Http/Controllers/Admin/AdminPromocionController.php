<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AdminPromocionController extends Controller
{
    /**
     * Listado de promociones.
     */
    public function index(): View
    {
        $promociones = Promocion::orderBy('orden')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.promociones.index', compact('promociones'));
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('admin.promociones.create');
    }

    /**
     * Guardar nueva promoción.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'       => ['required', 'string', 'max:255'],
            'resumen'      => ['nullable', 'string', 'max:1000'],
            'enlace_texto' => ['nullable', 'string', 'max:255'],
            // IMPORTANTE: string en vez de url para permitir /matriculate, /oposiciones, etc.
            'enlace_url'   => ['nullable', 'string', 'max:255'],
            'orden'        => ['nullable', 'integer', 'min:0'],
            'activo'       => ['nullable', 'boolean'],
        ], [
            'titulo.required'       => 'El título es obligatorio.',
            'titulo.max'            => 'El título no puede superar los 255 caracteres.',
            'resumen.max'           => 'El resumen no puede superar los 1000 caracteres.',
            'enlace_texto.max'      => 'El texto del enlace no puede superar los 255 caracteres.',
            'enlace_url.max'        => 'La URL del enlace no puede superar los 255 caracteres.',
            'orden.integer'         => 'El orden debe ser un número entero.',
            'orden.min'             => 'El orden no puede ser negativo.',
        ]);

        // Normalizamos
        $validated['activo'] = $request->boolean('activo');
        $validated['orden']  = $validated['orden'] ?? 0;

        try {
            Promocion::create($validated);
        } catch (\Throwable $e) {
            Log::error('Error al crear promoción', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Se ha producido un error al crear la promoción. Revisa los datos o inténtalo de nuevo.');
        }

        return redirect()
            ->route('admin.promociones.index')
            ->with('ok', 'Promoción creada correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Promocion $promocion): View
    {
        return view('admin.promociones.edit', compact('promocion'));
    }

    /**
     * Actualizar promoción.
     */
    public function update(Request $request, Promocion $promocion): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'       => ['required', 'string', 'max:255'],
            'resumen'      => ['nullable', 'string', 'max:1000'],
            'enlace_texto' => ['nullable', 'string', 'max:255'],
            // Igual que en store
            'enlace_url'   => ['nullable', 'string', 'max:255'],
            'orden'        => ['nullable', 'integer', 'min:0'],
            'activo'       => ['nullable', 'boolean'],
        ], [
            'titulo.required'       => 'El título es obligatorio.',
            'titulo.max'            => 'El título no puede superar los 255 caracteres.',
            'resumen.max'           => 'El resumen no puede superar los 1000 caracteres.',
            'enlace_texto.max'      => 'El texto del enlace no puede superar los 255 caracteres.',
            'enlace_url.max'        => 'La URL del enlace no puede superar los 255 caracteres.',
            'orden.integer'         => 'El orden debe ser un número entero.',
            'orden.min'             => 'El orden no puede ser negativo.',
        ]);

        $validated['activo'] = $request->boolean('activo');
        $validated['orden']  = $validated['orden'] ?? 0;

        try {
            $promocion->update($validated);
        } catch (\Throwable $e) {
            Log::error('Error al actualizar promoción', [
                'error' => $e->getMessage(),
                'id'    => $promocion->id,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Se ha producido un error al actualizar la promoción.');
        }

        return redirect()
            ->route('admin.promociones.index')
            ->with('ok', 'Promoción actualizada correctamente.');
    }

    /**
     * Eliminar promoción.
     */
    public function destroy(Promocion $promocion): RedirectResponse
    {
        try {
            $promocion->delete();
        } catch (\Throwable $e) {
            Log::error('Error al eliminar promoción', [
                'error' => $e->getMessage(),
                'id'    => $promocion->id,
            ]);

            return back()
                ->with('error', 'No se ha podido eliminar la promoción.');
        }

        return redirect()
            ->route('admin.promociones.index')
            ->with('ok', 'Promoción eliminada correctamente.');
    }
}
