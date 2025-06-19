<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasesToInvitacionesTable extends Migration
{
    public function up()
    {
        Schema::table('invitaciones', function (Blueprint $table) {
            $table->unsignedInteger('num_pases_solicitados')->nullable()->after('asistencia_confirmada');
            $table->unsignedInteger('num_pases_confirmados')->nullable()->after('num_pases_solicitados');
        });
    }

    public function down()
    {
        Schema::table('invitaciones', function (Blueprint $table) {
            $table->dropColumn(['num_pases_solicitados', 'num_pases_confirmados']);
        });
    }
}
