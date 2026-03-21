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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('grupo_id')->constrained()->onDelete('cascade');
            $table->decimal('parcial_1', 4, 1)->nullable();
            $table->decimal('parcial_2', 4, 1)->nullable();
            $table->decimal('parcial_3', 4, 1)->nullable();
            $table->decimal('final', 4, 1)->nullable()->comment('Calculado automáticamente: promedio de parciales');
            $table->timestamps();
            $table->unique(['user_id', 'grupo_id']); // Un alumno solo puede tener una calificación por grupo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
