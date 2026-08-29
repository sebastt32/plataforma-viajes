<?php

use App\Enums\EstadoPago;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->unique()->constrained('solicitudes')->cascadeOnDelete();
            $table->decimal('monto_producto', 10, 2);
            $table->decimal('fee_transporte', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('estado')->default(EstadoPago::Pendiente->value);
            $table->string('referencia')->unique();
            $table->timestamp('notificado_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
