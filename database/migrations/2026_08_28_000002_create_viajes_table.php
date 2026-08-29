<?php

use App\Enums\EstadoViaje;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viajero_id')->constrained('users')->cascadeOnDelete();
            $table->string('origen');
            $table->string('destino');
            $table->date('fecha_salida');
            $table->text('notas')->nullable();
            $table->string('estado')->default(EstadoViaje::Publicado->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
