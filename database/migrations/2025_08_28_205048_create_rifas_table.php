<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rifas', function (Blueprint $table) {
            $table->engine   = 'InnoDB';
            $table->charset  = 'utf8mb4';
            $table->collation= 'utf8mb4_unicode_ci';

            $table->bigIncrements('rifa_id');
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->string('causa', 200)->nullable();
            $table->string('imagen', 255)->nullable();

            $table->decimal('precio_boleto', 10, 2);
            $table->unsignedInteger('total_boletos');
            $table->unsignedInteger('numeracion_desde')->default(1);
            $table->unsignedInteger('numeracion_hasta');

            $table->unsignedInteger('max_boletos_por_usuario')->nullable();

            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();

            $table->enum('estado', ['borrador','activa','pausada','cerrada','sorteada'])->default('borrador');

            $table->unsignedBigInteger('ganador_boleto_id')->nullable();
            $table->unsignedBigInteger('ganador_user_id')->nullable();

            $table->timestamp('fyh_creacion')->useCurrent();
            $table->timestamp('fyh_actualizacion')->nullable()->useCurrentOnUpdate();

            $table->index(['estado']);
        });

        Schema::table('rifas', function (Blueprint $table) {
            if (Schema::hasTable('rifa_boletos')) {
                $table->foreign('ganador_boleto_id')->references('rifa_boleto_id')->on('rifa_boletos')->nullOnDelete();
            }
            if (Schema::hasTable('users')) {
                $table->foreign('ganador_user_id')->references('id')->on('users')->nullOnDelete();
            }
        });
    }

    public function down(): void {
        Schema::table('rifas', function (Blueprint $table) {
            $table->dropForeign(['ganador_boleto_id']);
            $table->dropForeign(['ganador_user_id']);
        });
        Schema::dropIfExists('rifas');
    }
};
