<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBoletosColumnInConfirmacionesTable extends Migration
{
    public function up()
    {
        Schema::table('confirmaciones', function (Blueprint $table) {
            $table->dropColumn('boletos');
        });

        Schema::table('confirmaciones', function (Blueprint $table) {
            $table->integer('boletos')->nullable();
        });
    }

    public function down()
    {
        Schema::table('confirmaciones', function (Blueprint $table) {
            $table->dropColumn('boletos');
        });

        Schema::table('confirmaciones', function (Blueprint $table) {
            $table->enum('boletos', ['Sí', 'No'])->nullable();
        });
    }
}
