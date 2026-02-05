<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación N:N con noticias.
     *
     * Tabla pivote: categoria_noticia
     */
    public function noticias()
    {
        return $this->belongsToMany(\App\Models\Noticia::class, 'categoria_noticia');
    }
}
