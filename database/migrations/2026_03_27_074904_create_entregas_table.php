<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained()->onDelete('cascade');
            $table->foreignId('alumno_id')->constrained('users')->onDelete('cascade');
            $table->string('archivo'); // PDF
            $table->string('estado')->default('entregado'); // entregado, revisado
            $table->text('comentario_profesor')->nullable();
            $table->timestamps();

            // Una entrega por tarea
            $table->unique(['tarea_id', 'alumno_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};