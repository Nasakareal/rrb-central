<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campus', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 30)->nullable()->unique();
            $table->string('nombre', 150);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->nullable()->constrained('campus')->nullOnDelete();
            $table->string('nombre', 150);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['campus_id', 'activo']);
        });

        Schema::create('puestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->unsignedSmallInteger('tolerancia_entrada_minutos')->default(0);
            $table->unsignedSmallInteger('tolerancia_salida_minutos')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('puestos');
        Schema::dropIfExists('departamentos');
        Schema::dropIfExists('campus');
    }
};
