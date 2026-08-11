<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $columnAdded = false;

        if (!Schema::hasColumn('asistencias', 'llave_registro')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->string('llave_registro', 40)->nullable()->after('archivo_origen');
            });

            $columnAdded = true;
        }

        DB::table('asistencias')
            ->select(['id', 'empleado_id', 'fecha', 'entrada', 'salida'])
            ->where(function ($query) {
                $query->whereNull('llave_registro')
                    ->orWhere('llave_registro', '');
            })
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('asistencias')
                        ->where('id', $row->id)
                        ->update([
                            'llave_registro' => sha1(implode('|', [
                                $row->empleado_id,
                                $row->fecha,
                                $row->entrada,
                                $row->salida ?: '',
                            ])),
                        ]);
                }
            });

        if ($columnAdded) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->unique('llave_registro', 'asistencias_llave_registro_unique');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('asistencias', 'llave_registro')) {
            Schema::table('asistencias', function (Blueprint $table) {
                $table->dropUnique('asistencias_llave_registro_unique');
                $table->dropColumn('llave_registro');
            });
        }
    }
};
