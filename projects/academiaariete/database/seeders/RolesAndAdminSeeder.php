<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Crear roles básicos si no existen
        $roleAdmin    = Role::firstOrCreate(['name' => 'admin',    'guard_name' => 'web']);
        $roleProfesor = Role::firstOrCreate(['name' => 'profesor', 'guard_name' => 'web']);
        $roleAlumno   = Role::firstOrCreate(['name' => 'alumno',   'guard_name' => 'web']);

        // 2) Buscar un usuario existente (por ejemplo el primero)
        $user = User::first();

        // Si no hay ningún usuario, creamos uno de ejemplo
        if (! $user) {
            $user = User::create([
                'name'     => 'Administrador',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('administrador'), // 👉 cámbialo luego en producción
            ]);
        }

        // 3) Asignarle el rol admin si todavía no lo tiene
        if (! $user->hasRole('admin')) {
            $user->assignRole($roleAdmin);
        }

        // (Opcional) Podrías asignar por defecto rol alumno a otros usuarios,
        // o crear algún profesor de prueba, pero de momento dejamos solo el admin.
    }
}
