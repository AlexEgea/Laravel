<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Listado público de noticias (con búsqueda y filtro por categoría).
     */
    public function index(Request $request)
    {
        $q           = $request->input('q', '');
        $categoriaId = $request->input('categoria');

        $noticiasQuery = Noticia::with(['autor', 'categorias'])
            ->whereNotNull('publicado_en')     // solo publicadas
            ->buscar($q)                       // scopeBuscar del modelo Noticia
            ->orderByDesc('publicado_en')
            ->orderByDesc('created_at');

        // Filtro por categoría si viene ?categoria=ID
        if ($categoriaId) {
            $noticiasQuery->whereHas('categorias', function ($query) use ($categoriaId) {
                $query->where('categorias.id', $categoriaId);
            });
        }

        // 10 noticias por página + mantener filtros en la paginación
        $noticias = $noticiasQuery
            ->paginate(9)
            ->appends($request->only('q', 'categoria'));

        // Para mostrar la categoría activa (nombre)
        $categoriaActiva = null;
        if ($categoriaId) {
            $categoriaActiva = Categoria::find($categoriaId);
        }

        return view('noticias.index', [
            'noticias'        => $noticias,
            'categoriaActiva' => $categoriaActiva,
        ]);
    }

    /**
     * Ficha pública de una noticia.
     */
    public function show(Noticia $noticia)
    {
        // Si no está publicada, 404
        if (is_null($noticia->publicado_en)) {
            abort(404);
        }

        $noticia->load(['autor', 'categorias']);

        return view('noticias.show', compact('noticia'));
    }
}
