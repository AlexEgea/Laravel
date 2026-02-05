<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('curso_usuario', function (Blueprint $table) {
            // Claves foráneas principales
            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->cascadeOnDelete();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Admin que realiza la asignación (opcional)
            $table->foreignId('asignado_por')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Clave primaria compuesta (curso_id + user_id)
            $table->primary(['curso_id', 'user_id']);

            // Marcas de tiempo
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_usuario');
    }
};
