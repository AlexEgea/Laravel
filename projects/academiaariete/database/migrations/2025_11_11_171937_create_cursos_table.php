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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            // Datos básicos
            $table->string('titulo');
            $table->string('slug')->unique();

            // Tipo de registro:
            // - 'seccion'   → familias / bloques (Enseñanza, Maestro, etc.)
            // - 'oposicion' → oposiciones concretas (Maestros Primaria, etc.)
            $table->string('tipo')->default('oposicion')->index();

            // Jerarquía: sección padre (por ejemplo Maestro dentro de Enseñanza)
            $table->unsignedBigInteger('parent_id')->nullable()->index();

            // Opcional: ordenar cómo aparecen en los listados
            $table->unsignedInteger('orden')->default(0)->index();

            // Textos
            $table->text('resumen')->nullable();
            $table->longText('descripcion')->nullable();

            // Estado
            $table->boolean('activo')->default(true)->index();

            $table->timestamps();

            // Si quieres forzar integridad referencial (no es obligatorio, pero recomendable):
            // $table->foreign('parent_id')
            //       ->references('id')
            //       ->on('cursos')
            //       ->nullOnDelete();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
