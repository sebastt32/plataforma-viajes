<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->string('imagen_externa_url', 2048)->nullable()->after('imagen_path');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->string('imagen_externa_url', 2048)->nullable()->after('imagen_path');
        });
    }

    public function down(): void
    {
        Schema::table('viajes', function (Blueprint $table) {
            $table->dropColumn('imagen_externa_url');
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('imagen_externa_url');
        });
    }
};
