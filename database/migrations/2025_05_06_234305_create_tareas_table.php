<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    Schema::create('tareas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('titulo');
        $table->text('descripcion');
        $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
        $table->enum('estado', ['pendiente', 'completada'])->default('pendiente');
        $table->date('fecha_vencimiento')->nullable();
        $table->json('comentarios')->nullable();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
