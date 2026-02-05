<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\ArchivoCurso;
use App\Models\HiloForo;

class Curso extends Model
{
    use HasFactory;

    // Si tu tabla se llama "cursos", no hace falta poner $table
    // protected $table = 'cursos';

    /**
     * Campos que se pueden asignar de forma masiva.
     */
    protected $fillable = [
        'titulo',
        'slug',
        'resumen',           // texto corto para tarjetas
        'descripcion',       // HTML largo
        'tipo',              // 'seccion' | 'oposicion' | (otros tipos si quieres)
        'parent_id',         // sección padre (otra fila de cursos)
        'activo',
        'publicado_en',

        // NUEVOS CAMPOS DE DETALLE PARA OPOSICIONES
        'convocatoria_anual',
        'requisitos',
        'examen',
        'concurso',
        'horario_precios',
        'equipo_docente',
    ];

    /**
     * Casts para fechas y booleanos.
     */
    protected $casts = [
        'publicado_en' => 'datetime',
        'activo'       => 'boolean',
    ];

    /**
     * Relación muchos a muchos:
     * Alumnos matriculados en este curso.
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'curso_usuario'   // nombre de la tabla pivot
        )->withTimestamps();
    }

    /**
     * Relación muchos a muchos:
     * Profesores que imparten este curso.
     */
    public function profesores(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'curso_profesor'  // nombre de la tabla pivot
        )->withTimestamps();
    }

    /**
     * Relación uno a muchos:
     * Archivos (materiales, PDFs, etc.) asociados a este curso.
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoCurso::class);
    }

    /**
     * Relación uno a muchos:
     * Hilos de foro asociados a este curso.
     */
    public function hilosForo(): HasMany
    {
        return $this->hasMany(HiloForo::class);
    }

    /**
     * Hijos: oposiciones o subcursos que cuelgan de esta sección.
     */
    public function hijos(): HasMany
    {
        return $this->hasMany(Curso::class, 'parent_id');
    }

    /**
     * Padre: sección de la que cuelga este curso/oposición.
     */
    public function padre(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'parent_id');
    }
}
