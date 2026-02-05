<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añadimos campos para gestionar secciones y oposiciones
     * dentro de la tabla cursos.
     */
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            // Tipo de registro: 'seccion' o 'oposicion' (y en el futuro, si quieres, 'curso')
            if (!Schema::hasColumn('cursos', 'tipo')) {
                $table->string('tipo', 50)
                    ->nullable()
                    ->after('slug')
                    ->index();
            }

            // Relación padre-hijo: una oposición puede pertenecer a una sección
            if (!Schema::hasColumn('cursos', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')
                    ->nullable()
                    ->after('tipo')
                    ->index();

                $table->foreign('parent_id')
                    ->references('id')
                    ->on('cursos')
                    ->nullOnDelete(); // al borrar sección, hijos pasan a parent_id = null
            }

            // Resumen corto (para tarjetas)
            if (!Schema::hasColumn('cursos', 'resumen')) {
                $table->text('resumen')
                    ->nullable()
                    ->after('titulo');
            }

            // Descripción larga en HTML (igual que contenido de noticias)
            if (!Schema::hasColumn('cursos', 'descripcion')) {
                $table->longText('descripcion')
                    ->nullable()
                    ->after('resumen');
            }

            // Publicado / borrador
            if (!Schema::hasColumn('cursos', 'activo')) {
                $table->boolean('activo')
                    ->default(true)
                    ->after('fecha_fin');
            }

            // Fecha de publicación (para futuro orden, filtros, etc.)
            if (!Schema::hasColumn('cursos', 'publicado_en')) {
                $table->timestamp('publicado_en')
                    ->nullable()
                    ->after('activo');
            }
        });
    }

    /**
     * Revertir cambios si hiciera falta.
     */
    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            // Quitamos la FK antes de borrar parent_id
            if (Schema::hasColumn('cursos', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }

            // Estas columnas puede que no existan si algo cambió, por eso comprobamos
            if (Schema::hasColumn('cursos', 'tipo')) {
                $table->dropColumn('tipo');
            }
            if (Schema::hasColumn('cursos', 'resumen')) {
                $table->dropColumn('resumen');
            }
            if (Schema::hasColumn('cursos', 'descripcion')) {
                $table->dropColumn('descripcion');
            }
            if (Schema::hasColumn('cursos', 'activo')) {
                $table->dropColumn('activo');
            }
            if (Schema::hasColumn('cursos', 'publicado_en')) {
                $table->dropColumn('publicado_en');
            }
        });
    }
};
