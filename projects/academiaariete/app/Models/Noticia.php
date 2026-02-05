<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'resumen',
        'contenido',
        'imagen',
        'publicado_en',
        'user_id',
    ];

    protected $casts = [
        'publicado_en' => 'datetime',
    ];

    /**
     * Autor de la noticia (usuario que la creó).
     */
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Categorías asociadas a la noticia (N:M).
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_noticia');
    }

    /**
     * Scope de búsqueda por título, resumen o contenido.
     *
     * Uso: Noticia::buscar($q)->get();
     */
    public function scopeBuscar($query, ?string $term)
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('titulo', 'like', "%{$term}%")
              ->orWhere('resumen', 'like', "%{$term}%")
              ->orWhere('contenido', 'like', "%{$term}%");
        });
    }
}
