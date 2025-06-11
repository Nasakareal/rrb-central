<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmacionesTable extends Migration
{
    public function up()
    {
        Schema::create('confirmaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono', 20);
            $table->string('email');
            $table->enum('asistencia', ['Sí', 'No']);
            $table->enum('boletos', ['Sí', 'No'])->nullable();
            $table->text('mensaje')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('confirmaciones');
    }
}
