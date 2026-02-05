<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo añadimos los campos si NO existen aún

            // APELLIDOS
            if (!Schema::hasColumn('users', 'apellidos')) {
                $table->string('apellidos', 30)
                      ->nullable()
                      ->after('name');
            }

            // TELÉFONO
            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono', 15)
                      ->nullable()
                      ->after('email');
            }

            // DIRECCIÓN
            if (!Schema::hasColumn('users', 'direccion')) {
                $table->string('direccion', 100)
                      ->nullable()
                      ->after('telefono');
            }

            // FOTO
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto', 255)
                      ->nullable()
                      ->after('direccion');
            }

            // FLAG must_reset_password
            if (!Schema::hasColumn('users', 'must_reset_password')) {
                $table->boolean('must_reset_password')
                      ->default(false)
                      ->after('foto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Borramos solo si existen (en orden inverso por si acaso)

            if (Schema::hasColumn('users', 'must_reset_password')) {
                $table->dropColumn('must_reset_password');
            }

            if (Schema::hasColumn('users', 'foto')) {
                $table->dropColumn('foto');
            }

            if (Schema::hasColumn('users', 'direccion')) {
                $table->dropColumn('direccion');
            }

            if (Schema::hasColumn('users', 'telefono')) {
                $table->dropColumn('telefono');
            }

            if (Schema::hasColumn('users', 'apellidos')) {
                $table->dropColumn('apellidos');
            }
        });
    }
};
