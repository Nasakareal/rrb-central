<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->string('tipo_personal', 30)->default('administrativo')->after('correo');
        });

        Schema::table('horarios', function (Blueprint $table) {
            $table->string('dias_semana', 20)->default('1,2,3,4,5')->after('hora_salida');
        });

        Schema::create('asistencia_justificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->cascadeOnDelete();
            $table->foreignId('asistencia_id')->nullable()->constrained('asistencias')->nullOnDelete();
            $table->foreignId('horario_id')->nullable()->constrained('horarios')->nullOnDelete();
            $table->date('fecha');
            $table->string('codigo_incidencia', 30);
            $table->string('tipo_justificacion', 60);
            $table->text('descripcion');
            $table->string('documento_referencia', 255)->nullable();
            $table->string('estado', 20)->default('aprobada');
            $table->boolean('evita_descuento')->default(true);
            $table->foreignId('justificada_por')->nullable()->constrained('users')->nullOnDelete();
            $table->string('origen', 20)->default('web');
            $table->timestamps();

            $table->index(['empleado_id', 'fecha']);
            $table->index(['codigo_incidencia', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencia_justificaciones');

        Schema::table('horarios', function (Blueprint $table) {
            $table->dropColumn('dias_semana');
        });

        Schema::table('empleados', function (Blueprint $table) {
            $table->dropColumn('tipo_personal');
        });
    }
};
