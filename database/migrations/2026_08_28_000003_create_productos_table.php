<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viajero_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('viaje_id')->constrained('viajes')->cascadeOnDelete();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->decimal('fee_transporte', 10, 2);
            $table->unsignedTinyInteger('cantidad_max');
            $table->unsignedTinyInteger('cantidad_disponible');
            $table->string('imagen_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
