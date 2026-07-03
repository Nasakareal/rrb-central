<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('numero_reloj', 50)->unique();
            $table->string('numero_empleado', 50)->nullable()->unique();
            $table->string('nombre', 150)->nullable();
            $table->string('apellido_paterno', 100)->nullable();
            $table->string('apellido_materno', 100)->nullable();
            $table->foreignId('campus_id')->nullable()->constrained('campus')->nullOnDelete();
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->nullOnDelete();
            $table->foreignId('puesto_id')->nullable()->constrained('puestos')->nullOnDelete();
            $table->string('estatus', 20)->default('activo');
            $table->date('fecha_ingreso')->nullable();
            $table->timestamps();

            $table->index(['estatus', 'campus_id']);
            $table->index(['departamento_id', 'puesto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
