<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminNoticiaController extends Controller
{
    /**
     * Listado de noticias (con buscador y paginación de 10 en 10).
     */
    public function index(Request $request): View
    {
        $q = trim($request->input('q', ''));

        $noticias = Noticia::with(['autor', 'categorias'])
            ->when($q, function ($query, $q) {
                $like = '%' . $q . '%';

                $query->where(function ($sub) use ($like) {
                    $sub->where('titulo', 'like', $like)
                        ->orWhere('resumen', 'like', $like)
                        ->orWhere('contenido', 'like', $like);
                });
            })
            ->orderByDesc('publicado_en')
            ->orderByDesc('created_at')
            ->paginate(10)          // 10 noticias por página
            ->withQueryString();    // mantiene ?q= en todas las páginas

        return view('admin.noticias.index', compact('noticias', 'q'));
    }

    /**
     * Formulario crear noticia.
     */
    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.noticias.create', compact('categorias'));
    }

    /**
     * Guardar noticia nueva.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'            => ['required', 'string', 'max:255'],
            'resumen'           => ['nullable', 'string', 'max:500'],
            'contenido'         => ['required', 'string'],

            // Imagen opcional, máximo 2MB, formatos típicos
            'imagen'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'estado'            => ['required', 'in:publicar,borrador'],

            // Categorías existentes seleccionadas en el form
            'categorias'        => ['nullable', 'array'],
            'categorias.*'      => ['integer', 'exists:categorias,id'],

            // Nuevas categorías (separadas por comas)
            'nuevas_categorias' => ['nullable', 'string', 'max:255'],
        ], [
            'titulo.required'            => 'El título es obligatorio.',
            'titulo.max'                 => 'El título no puede superar los 255 caracteres.',
            'resumen.max'                => 'El resumen no puede superar los 500 caracteres.',
            'contenido.required'         => 'El contenido de la noticia es obligatorio.',
            'imagen.image'               => 'El archivo subido debe ser una imagen.',
            'imagen.mimes'               => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen.max'                 => 'La imagen no puede superar los 2 MB.',
            'estado.required'            => 'Debes indicar si la noticia se publica o se guarda como borrador.',
            'estado.in'                  => 'El estado seleccionado no es válido.',
            'categorias.array'           => 'El formato de las categorías seleccionadas no es válido.',
            'categorias.*.integer'       => 'Cada categoría seleccionada debe ser un identificador válido.',
            'categorias.*.exists'        => 'Alguna de las categorías seleccionadas no existe.',
            'nuevas_categorias.max'      => 'El campo de nuevas categorías no puede superar los 255 caracteres.',
        ]);

        // Imagen
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        // Estado publicación
        if ($validated['estado'] === 'publicar') {
            $validated['publicado_en'] = now();
        } else {
            $validated['publicado_en'] = null;
        }

        $validated['user_id'] = Auth::id();

        // Creamos noticia
        $noticia = Noticia::create([
            'titulo'       => $validated['titulo'],
            'resumen'      => $validated['resumen'] ?? null,
            'contenido'    => $validated['contenido'],
            'imagen'       => $validated['imagen'] ?? null,
            'user_id'      => $validated['user_id'],
            'publicado_en' => $validated['publicado_en'],
        ]);

        // Categorías
        $categoriaIds = $request->input('categorias', []);

        if (!empty($validated['nuevas_categorias'])) {
            $nuevas = collect(explode(',', $validated['nuevas_categorias']))
                ->map(fn ($c) => trim($c))
                ->filter()
                ->unique();

            foreach ($nuevas as $nombre) {
                $categoria = Categoria::firstOrCreate(['nombre' => $nombre]);
                $categoriaIds[] = $categoria->id;
            }
        }

        if (!empty($categoriaIds)) {
            $noticia->categorias()->sync($categoriaIds);
        }

        return redirect()
            ->route('admin.noticias.index')
            ->with('status', 'Noticia creada correctamente.');
    }

    /**
     * Formulario editar noticia.
     */
    public function edit(Noticia $noticia): View
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $noticia->load('categorias');

        return view('admin.noticias.edit', [
            'noticia'    => $noticia,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Actualizar noticia.
     */
    public function update(Request $request, Noticia $noticia): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'            => ['required', 'string', 'max:255'],
            'resumen'           => ['nullable', 'string', 'max:500'],
            'contenido'         => ['required', 'string'],

            'imagen'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'estado'            => ['required', 'in:publicar,borrador'],

            'categorias'        => ['nullable', 'array'],
            'categorias.*'      => ['integer', 'exists:categorias,id'],

            'nuevas_categorias' => ['nullable', 'string', 'max:255'],
        ], [
            'titulo.required'            => 'El título es obligatorio.',
            'titulo.max'                 => 'El título no puede superar los 255 caracteres.',
            'resumen.max'                => 'El resumen no puede superar los 500 caracteres.',
            'contenido.required'         => 'El contenido de la noticia es obligatorio.',
            'imagen.image'               => 'El archivo subido debe ser una imagen.',
            'imagen.mimes'               => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen.max'                 => 'La imagen no puede superar los 2 MB.',
            'estado.required'            => 'Debes indicar si la noticia se publica o se guarda como borrador.',
            'estado.in'                  => 'El estado seleccionado no es válido.',
            'categorias.array'           => 'El formato de las categorías seleccionadas no es válido.',
            'categorias.*.integer'       => 'Cada categoría seleccionada debe ser un identificador válido.',
            'categorias.*.exists'        => 'Alguna de las categorías seleccionadas no existe.',
            'nuevas_categorias.max'      => 'El campo de nuevas categorías no puede superar los 255 caracteres.',
        ]);

        // Imagen: si se sube nueva, borramos la anterior
        if ($request->hasFile('imagen')) {
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        // Estado publicación
        if ($validated['estado'] === 'publicar') {
            if (is_null($noticia->publicado_en)) {
                // Si estaba en borrador y ahora se publica, ponemos fecha de publicación
                $noticia->publicado_en = now();
            }
        } else {
            // Borrador
            $noticia->publicado_en = null;
        }

        $noticia->titulo    = $validated['titulo'];
        $noticia->resumen   = $validated['resumen'] ?? null;
        $noticia->contenido = $validated['contenido'];

        if (isset($validated['imagen'])) {
            $noticia->imagen = $validated['imagen'];
        }

        $noticia->save();

        // Categorías
        $categoriaIds = $request->input('categorias', []);

        if (!empty($validated['nuevas_categorias'])) {
            $nuevas = collect(explode(',', $validated['nuevas_categorias']))
                ->map(fn ($c) => trim($c))
                ->filter()
                ->unique();

            foreach ($nuevas as $nombre) {
                $categoria = Categoria::firstOrCreate(['nombre' => $nombre]);
                $categoriaIds[] = $categoria->id;
            }
        }

        $noticia->categorias()->sync($categoriaIds);

        return redirect()
            ->route('admin.noticias.index')
            ->with('status', 'Noticia actualizada correctamente.');
    }

    /**
     * Eliminar noticia.
     */
    public function destroy(Noticia $noticia): RedirectResponse
    {
        if ($noticia->imagen) {
            Storage::disk('public')->delete($noticia->imagen);
        }

        $noticia->categorias()->detach();
        $noticia->delete();

        return redirect()
            ->route('admin.noticias.index')
            ->with('status', 'Noticia eliminada correctamente.');
    }
}
