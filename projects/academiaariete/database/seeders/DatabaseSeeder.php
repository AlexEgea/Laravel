<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Si quieres seguir creando un usuario de prueba, puedes dejar esto:
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 👉 Llamamos a nuestro seeder de roles y admin
        $this->call([
            RolesAndAdminSeeder::class,
        ]);
    }
}
