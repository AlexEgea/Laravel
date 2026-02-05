<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('familia', 100)
                ->nullable()
                ->after('es_oposicion')
                ->index();

            $table->string('subfamilia', 150)
                ->nullable()
                ->after('familia');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn(['familia', 'subfamilia']);
        });
    }
};
