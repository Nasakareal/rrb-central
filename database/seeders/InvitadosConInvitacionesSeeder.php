<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvitadosConInvitacionesSeeder extends Seeder
{
    public function run()
    {
        $invitados = [
            ['name' => 'Zoe', 'email' => 'Zoe@example.com', 'pases' => 1],
            ['name' => 'Valeria', 'email' => 'Valeria@example.com', 'pases' => 1],
            ['name' => 'María José', 'email' => 'Maria_jose@example.com', 'pases' => 1],
            ['name' => 'Katherine', 'email' => 'Katherine@example.com', 'pases' => 1],
            ['name' => 'Kimberly', 'email' => 'Kimberly@example.com', 'pases' => 1],
            ['name' => 'Sofia', 'email' => 'Sofia@example.com', 'pases' => 1],
            ['name' => 'Araci', 'email' => 'Arci@example.com', 'pases' => 1],
            ['name' => 'Erick', 'email' => 'Erick@example.com', 'pases' => 1],
            ['name' => 'Jesús', 'email' => 'Jesus@example.com', 'pases' => 1],
            ['name' => 'Uriel', 'email' => 'Uriel@example.com', 'pases' => 1],
            ['name' => 'Jonathan', 'email' => 'Jonathan@example.com', 'pases' => 1],
            ['name' => 'Iker', 'email' => 'Iker@example.com', 'pases' => 1],
            ['name' => 'Santos', 'email' => 'Santos@example.com', 'pases' => 1],
            ['name' => 'Josue', 'email' => 'Josue@example.com', 'pases' => 1],
            ['name' => 'Osvaldo', 'email' => 'Osvaldo@example.com', 'pases' => 1],
            ['name' => 'Hugo', 'email' => 'Hugo@example.com', 'pases' => 1],
            ['name' => 'Ivan', 'email' => 'Ivan@example.com', 'pases' => 1],
            ['name' => 'Gabo', 'email' => 'Gabo@example.com', 'pases' => 1],
            ['name' => 'Aneida', 'email' => 'Aneida@example.com', 'pases' => 1],
            ['name' => 'Zujeili', 'email' => 'Zujeili@example.com', 'pases' => 1],
            ['name' => 'Tadeo', 'email' => 'Tadeo@example.com', 'pases' => 1],
            ['name' => 'Santiago', 'email' => 'Santiago@example.com', 'pases' => 1],
            ['name' => 'Hernandez Yepez', 'email' => 'Hernandez_Yepez@example.com', 'pases' => 4],
            ['name' => 'Concepción Flores', 'email' => 'Concepcion_Flores@example.com', 'pases' => 2],
            ['name' => 'Olvera Calderón Erika', 'email' => 'Olvera_calderon@example.com', 'pases' => 11],
            ['name' => 'Cortés Rangel Maira', 'email' => 'Cortés_rangel_maira@example.com', 'pases' => 2],
            ['name' => 'Ahumada Millan Iberia', 'email' => 'Ahumada_millan_iberia@example.com', 'pases' => 11],
            ['name' => 'Diaz Ochoa Adriana', 'email' => 'Diaz_ochoa_adriana@example.com', 'pases' => 4],
            ['name' => 'Aguilar Quintero Jesus', 'email' => 'Aguilar_quintero_jesus@example.com', 'pases' => 6],
            ['name' => 'Ruiz Vega Adrian', 'email' => 'Ruiz_vega_adrian@example.com', 'pases' => 3],
            ['name' => 'Jorge', 'email' => 'Jorge@example.com', 'pases' => 2],
            ['name' => 'Mora Barajas Tamar', 'email' => 'Mora_barajas_tamar@example.com', 'pases' => 4],
            ['name' => 'Martita', 'email' => 'Martita@example.com', 'pases' => 2],
            ['name' => 'Heber Calderón', 'email' => 'Heber_calderon@example.com', 'pases' => 4],
            ['name' => 'Gaby', 'email' => 'Gaby@example.com', 'pases' => 5],
            ['name' => 'Carlos Castañeda', 'email' => 'Carlos_castañeda@example.com', 'pases' => 2],
        ];

        foreach ($invitados as $inv) {
            $userId = DB::table('users')->insertGetId([
                'name' => $inv['name'],
                'email' => $inv['email'],
                'password' => bcrypt('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('invitaciones')->insert([
                'user_id' => $userId,
                'evento_id' => 1,
                'qr_token' => Str::uuid(),
                'asistencia_confirmada' => 0,
                'num_pases_solicitados' => $inv['pases'],
                'num_pases_confirmados' => $inv['pases'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
