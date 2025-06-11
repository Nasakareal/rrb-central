<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventoIdToConfirmacionesTable extends Migration
{
    public function up()
    {
        Schema::table('confirmaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('evento_id')->after('id');
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('confirmaciones', function (Blueprint $table) {
            //
        });
    }
}
