<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Spatie
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Curso;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Atributos asignables en masa.
     */
    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'telefono',
        'direccion',
        'foto',
        'must_reset_password',
    ];

    /**
     * Atributos ocultos en arrays/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',   // sigue funcionando igual que antes
            'must_reset_password' => 'boolean',  // 👈 NUEVO FLAG
        ];
    }

    /**
     * Cursos en los que el usuario está matriculado como alumno.
     */
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(
            Curso::class,      // Modelo relacionado
            'curso_usuario'    // Nombre de la tabla pivot en tu BD
        )->withTimestamps();   // Mantiene created_at / updated_at en la pivot
    }

    /**
     * Cursos en los que el usuario participa como profesor.
     */
    public function cursosComoProfesor(): BelongsToMany
    {
        return $this->belongsToMany(
            Curso::class,
            'curso_profesor'   // Tabla pivot para profesor-curso
        )->withTimestamps();
    }
}
