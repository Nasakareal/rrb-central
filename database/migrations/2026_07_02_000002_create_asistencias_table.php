<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->cascadeOnDelete();
            $table->date('fecha');
            $table->time('entrada');
            $table->time('salida')->nullable();
            $table->unsignedInteger('total_marcas')->default(0);
            $table->text('observaciones')->nullable();
            $table->string('archivo_origen', 255)->nullable();
            $table->timestamps();

            $table->unique(
                ['empleado_id', 'fecha', 'entrada', 'salida'],
                'asistencias_empleado_fecha_entrada_salida_unique'
            );
            $table->index(['fecha', 'empleado_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
