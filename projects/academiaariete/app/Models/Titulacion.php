<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Titulacion extends Model
{
    // Nombre real de la tabla
    protected $table = 'titulacion';

    // Si la tabla NO tiene created_at / updated_at
    public $timestamps = false;

    // Único campo rellenable que sabemos seguro que existe
    protected $fillable = [
        'nombre',
    ];

    // IMPORTANTE:
    // No usamos casts ni scopeActivas porque en la tabla
    // no existen las columnas 'activo' ni 'orden'.
}
