<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('poleos_importados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_archivo', 255);
            $table->string('hash_archivo', 128)->unique();
            $table->unsignedInteger('total_registros')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poleos_importados');
    }
};
