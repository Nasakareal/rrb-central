<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('biosync_licencias', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 120)->unique();
            $table->string('cliente', 160)->nullable();
            $table->string('equipo_id', 120)->nullable();
            $table->boolean('activa')->default(true);
            $table->date('fecha_vencimiento')->nullable();
            $table->dateTime('ultima_validacion')->nullable();
            $table->string('ultima_version', 40)->nullable();
            $table->timestamps();

            $table->index(['activa', 'fecha_vencimiento']);
            $table->index('equipo_id');
        });

        DB::table('biosync_licencias')->insert([
            'clave' => 'BIOSYNC-UTM-2026',
            'cliente' => 'Universidad Tecnologica de Morelia',
            'activa' => true,
            'fecha_vencimiento' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('biosync_licencias');
    }
};