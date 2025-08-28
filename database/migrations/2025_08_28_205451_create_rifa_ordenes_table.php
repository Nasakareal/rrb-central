<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rifa_ordenes', function (Blueprint $table) {
            $table->engine   = 'InnoDB';
            $table->charset  = 'utf8mb4';
            $table->collation= 'utf8mb4_unicode_ci';

            $table->bigIncrements('orden_id');

            $table->unsignedBigInteger('rifa_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('comprador_nombre', 120)->nullable();
            $table->string('comprador_telefono', 30)->nullable();
            $table->string('comprador_email', 120)->nullable();

            $table->unsignedInteger('total_boletos')->default(0);
            $table->decimal('monto_total', 10, 2)->default(0);

            $table->string('metodo_pago', 40)->nullable();
            $table->string('referencia_pago', 120)->nullable();
            $table->string('comprobante_url', 255)->nullable();

            $table->enum('estatus', ['pendiente','pagado','cancelado'])->default('pendiente');
            $table->dateTime('fyh_pago')->nullable();

            $table->timestamp('fyh_creacion')->useCurrent();
            $table->timestamp('fyh_actualizacion')->nullable()->useCurrentOnUpdate();

            $table->index(['rifa_id']);
            $table->index(['estatus']);

            $table->foreign('rifa_id')->references('rifa_id')->on('rifas')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        // Ahora sí: FK desde rifa_boletos.orden_id -> rifa_ordenes
        Schema::table('rifa_boletos', function (Blueprint $table) {
            $table->foreign('orden_id')->references('orden_id')->on('rifa_ordenes')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('rifa_boletos', function (Blueprint $table) {
            $table->dropForeign(['orden_id']);
        });
        Schema::dropIfExists('rifa_ordenes');
    }
};
