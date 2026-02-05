<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->longText('convocatoria_anual')->nullable();
            $table->longText('requisitos')->nullable();
            $table->longText('examen')->nullable();
            $table->longText('concurso')->nullable();
            $table->longText('horario_precios')->nullable();
            $table->longText('equipo_docente')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn([
                'convocatoria_anual',
                'requisitos',
                'examen',
                'concurso',
                'horario_precios',
                'equipo_docente',
            ]);
        });
    }
};
