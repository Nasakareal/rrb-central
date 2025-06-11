<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosEventoTable extends Migration
{
    public function up()
    {
        Schema::create('fotos_evento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->string('nombre_invitado')->nullable();
            $table->string('imagen_path');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fotos_evento');
    }
}
