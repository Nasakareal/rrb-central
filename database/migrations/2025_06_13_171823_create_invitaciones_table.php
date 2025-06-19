<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitacionesTable extends Migration
{
    public function up()
    {
        Schema::create('invitaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('evento_id')->constrained()->onDelete('cascade');
            $table->string('qr_token')->unique();
            $table->boolean('asistencia_confirmada')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitaciones');
    }
}
