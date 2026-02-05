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
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('resumen')->nullable();
            $table->string('enlace_texto')->nullable(); // Texto del botón ("Ver más", "Matricúlate", etc.)
            $table->string('enlace_url')->nullable();   // URL del botón
            $table->boolean('activo')->default(true);   // Para activar/desactivar sin borrar
            $table->integer('orden')->default(0);       // Posición en la portada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promociones');
    }
};
