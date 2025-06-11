<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpToFotosEventoTable extends Migration
{
    public function up()
    {
        Schema::table('fotos_evento', function ($table) {
            $table->string('ip', 45)->nullable()->after('comentario');
        });
    }

    public function down()
    {
        Schema::table('fotos_evento', function ($table) {
            $table->dropColumn('ip');
        });
    }

}
