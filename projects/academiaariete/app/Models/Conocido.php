<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conocido extends Model
{
    use HasFactory;

    // Nombre real de la tabla
    protected $table = 'conocido';

    // Campos rellenables en asignación masiva
    protected $fillable = [
        'nombre',
        'requiere_detalle', // por ejemplo para "Otros"
        'orden',
        'activo',
    ];

    // Casts para tipos nativos de PHP
    protected $casts = [
        'requiere_detalle' => 'boolean',
        'activo'           => 'boolean',
        'orden'            => 'integer',
    ];

    /**
     * Scope de ayuda:
     * Obtener solo opciones activas, ordenadas.
     *
     * Ejemplo de uso:
     * Conocido::activos()->get();
     */
    public function scopeActivos($query)
    {
        return $query
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre');
    }
}
