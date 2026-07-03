<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empleado_horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->cascadeOnDelete();
            $table->foreignId('horario_id')->constrained('horarios');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(
                ['empleado_id', 'horario_id', 'fecha_inicio'],
                'empleado_horarios_empleado_horario_inicio_unique'
            );
            $table->index(['empleado_id', 'activo']);
            $table->index(['fecha_inicio', 'fecha_fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado_horarios');
    }
};
