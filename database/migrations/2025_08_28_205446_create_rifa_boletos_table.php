<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rifa_boletos', function (Blueprint $table) {
            $table->engine   = 'InnoDB';
            $table->charset  = 'utf8mb4';
            $table->collation= 'utf8mb4_unicode_ci';

            $table->bigIncrements('rifa_boleto_id');

            $table->unsignedBigInteger('rifa_id');
            $table->unsignedInteger('numero');

            $table->enum('estado', ['disponible','apartado','vendido','anulado'])->default('disponible');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('orden_id')->nullable();

            $table->dateTime('reservado_hasta')->nullable();

            $table->timestamp('fyh_creacion')->useCurrent();
            $table->timestamp('fyh_actualizacion')->nullable()->useCurrentOnUpdate();

            $table->unique(['rifa_id','numero']);
            $table->index(['rifa_id','estado']);
            $table->index(['orden_id']);
            $table->index(['user_id']);

            $table->foreign('rifa_id')->references('rifa_id')->on('rifas')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rifa_boletos');
    }
};
