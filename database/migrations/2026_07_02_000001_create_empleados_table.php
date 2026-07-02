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
            $table->string('nombre', 150)->nullable();
            $table->unsignedBigInteger('campus_id')->nullable();
            $table->timestamps();

            $table->index('campus_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
