<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reloj_marcas', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 64)->unique();
            $table->string('dispositivo_id', 120)->nullable();
            $table->string('dispositivo_serial', 120)->nullable();
            $table->string('dispositivo_ip', 45)->nullable();
            $table->string('numero_reloj', 50);
            $table->dateTime('fecha_hora');
            $table->integer('modo_verificacion')->nullable();
            $table->integer('modo_entrada_salida')->nullable();
            $table->integer('codigo_trabajo')->nullable();
            $table->timestamps();

            $table->index(['numero_reloj', 'fecha_hora']);
            $table->index('dispositivo_serial');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reloj_marcas');
    }
};