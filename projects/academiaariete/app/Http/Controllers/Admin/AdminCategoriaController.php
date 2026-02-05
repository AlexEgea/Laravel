<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class AdminCategoriaController extends Controller
{
    /**
     * Elimina una categoría.
     * - La desvincula de las noticias (pivot) antes de borrarla
     *   para evitar errores de clave foránea.
     */
    public function destroy(Categoria $categoria)
    {
        DB::transaction(function () use ($categoria) {
            // Si tienes definida la relación en el modelo Categoria:
            // public function noticias() { return $this->belongsToMany(Noticia::class); }
            $categoria->noticias()->detach();

            $categoria->delete();
        });

        return back()->with(
            'status',
            'La categoría "' . $categoria->nombre . '" se ha eliminado correctamente.'
        );
    }
}
