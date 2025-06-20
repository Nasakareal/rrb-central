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
            ['name' => 'Tello Calderón', 'email' => 'tello.calderon@example.com', 'pases' => 5],
            ['name' => 'Olvera Calderón', 'email' => 'olvera.calderon@example.com', 'pases' => 6],
            ['name' => 'Roman Calderón', 'email' => 'roman.calderon@example.com', 'pases' => 3],
            ['name' => 'Roman Calderón Brenda', 'email' => 'brenda.roman.calderon@example.com', 'pases' => 3],
            ['name' => 'Millan Velazquez', 'email' => 'millan.velazquez@example.com', 'pases' => 3],
            ['name' => 'Millan Montes', 'email' => 'sue.lili.montes@example.com', 'pases' => 3],
            ['name' => 'Garcia Millan', 'email' => 'garcia.millan@example.com', 'pases' => 4],
            ['name' => 'Calderón Dorazco', 'email' => 'calderon.dorazco@example.com', 'pases' => 2],
            ['name' => 'Heredia Calderón More', 'email' => 'heredia.calderon.more@example.com', 'pases' => 2],
            ['name' => 'Morales Calderón Tia', 'email' => 'tia.morales.calderon@example.com', 'pases' => 3],
            ['name' => 'Morales Calderón Jaqui', 'email' => 'jaqui.morales.calderon@example.com', 'pases' => 3],
            ['name' => 'Ramirez Morales Jesi', 'email' => 'jesi.ramirez.morales@example.com', 'pases' => 3],
            ['name' => 'Morales Calderón Maris', 'email' => 'maris.morales.calderon@example.com', 'pases' => 3],
            ['name' => 'Calderón Guerrero Tluis', 'email' => 'tluis.calderon.guerrero@example.com', 'pases' => 4],
            ['name' => 'Cortés Hernandez Temo', 'email' => 'temo.cortes.hernandez@example.com', 'pases' => 5],
            ['name' => 'Cortés Rangel Bul', 'email' => 'tiobul.cortes.rangel@example.com', 'pases' => 2],
            ['name' => 'Cortés Rangel Guero', 'email' => 'guero.cortes.rangel@example.com', 'pases' => 2],
            ['name' => 'Cortés Rangel Moy', 'email' => 'moy.cortes.rangel@example.com', 'pases' => 4],
            ['name' => 'Cortés Rangel Chato', 'email' => 'chato.cortes.rangel@example.com', 'pases' => 4],
            ['name' => 'Cortés Rangel Rosa', 'email' => 'rosa.cortes.rangel@example.com', 'pases' => 4],
            ['name' => 'Cortés Rangel Chata', 'email' => 'chata.cortes.rangel@example.com', 'pases' => 2],
            ['name' => 'Cortés Cortés Jaime', 'email' => 'jaime.cortes.cortes@example.com', 'pases' => 5],
            ['name' => 'Cortés Cortés Lupita', 'email' => 'lupita.cortes.cortes@example.com', 'pases' => 3],
            ['name' => 'Rodriguez Avalos Diose', 'email' => 'diose.rodriguez.avalos@example.com', 'pases' => 5],
            ['name' => 'Montañes Avalos Eva', 'email' => 'eva.montanes.avalos@example.com', 'pases' => 5],
            ['name' => 'Reyes Medina Margot', 'email' => 'margot.reyes.medina@example.com', 'pases' => 2],
            ['name' => 'Corona Guzmán Meme', 'email' => 'meme.corona.guzman@example.com', 'pases' => 8],
            ['name' => 'Duarte Melchor', 'email' => 'gordo.duarte.melchor@example.com', 'pases' => 5],
            ['name' => 'Duarte Luis', 'email' => 'duarte.luis@example.com', 'pases' => 4],
            ['name' => 'Chagolla Millan Lore', 'email' => 'lore.chagolla.millan@example.com', 'pases' => 3],
            ['name' => 'Marilu Millan', 'email' => 'marilu.millan@example.com', 'pases' => 3],
            ['name' => 'Millan Nieves Gil Papa', 'email' => 'gil.papa.millan.nieves@example.com', 'pases' => 2],
            ['name' => 'Gildardo Millán', 'email' => 'gildardo.millan@example.com', 'pases' => 2],
            ['name' => 'Claudia Millan Claudita', 'email' => 'claudita.claudia.millan@example.com', 'pases' => 3],
            ['name' => 'Virgen Millan Claus', 'email' => 'claus.virgen.millan@example.com', 'pases' => 5],
            ['name' => 'Villagomez Millan Juni', 'email' => 'juni.villagomez.millan@example.com', 'pases' => 3],
            ['name' => 'Mora Guzmán Verito', 'email' => 'verito.mora.guzman@example.com', 'pases' => 4],
            ['name' => 'Guzmán Villa Pancho', 'email' => 'pancho.guzman.villa@example.com', 'pases' => 4],
            ['name' => 'Guzmán Guerrero Salo', 'email' => 'salo.guzman.guerrero@example.com', 'pases' => 2],
            ['name' => 'Daniel y Vicky Guzman', 'email' => 'danielyvicky.guzman@example.com', 'pases' => 8],
            ['name' => 'Ahumada Millan Iberia', 'email' => 'iberia.ahumada.millan@example.com', 'pases' => 1],
            ['name' => 'Angela Millan', 'email' => 'angela.millan@example.com', 'pases' => 2],
            ['name' => 'Chavez Tapia Martha', 'email' => 'martha.chavez.tapia@example.com', 'pases' => 5],
            ['name' => 'Marta Torres', 'email' => 'marta.torres@example.com', 'pases' => 2],
            ['name' => 'Marin Carrillo Gustavo', 'email' => 'gustavo.marin.carrillo@example.com', 'pases' => 5],
            ['name' => 'Serrato del Moral Esme', 'email' => 'esme.serrato.delmoral@example.com', 'pases' => 5],
            ['name' => 'Celaya Maciel Ulices', 'email' => 'ulices.celaya.maciel@example.com', 'pases' => 5],
            ['name' => 'Julio Bautista', 'email' => 'julio.bautista@example.com', 'pases' => 5],
            ['name' => 'Sanchez Suquilvide Dani', 'email' => 'dani.sanchez.suquilvide@example.com', 'pases' => 4],
            ['name' => 'Becerril Fuentes Pao', 'email' => 'pao.becerril.fuentes@example.com', 'pases' => 5],
            ['name' => 'Oseguera Cortes', 'email' => 'jefe.oseguera.cortes@example.com', 'pases' => 4],
            ['name' => 'Ortega Silva', 'email' => 'pepe.ortega.silva@example.com', 'pases' => 4],
            ['name' => 'Fernando Rubalcava', 'email' => 'fernando.ruvalcaba@example.com', 'pases' => 2],
            ['name' => 'Piña', 'email' => 'pina@example.com', 'pases' => 2],
            ['name' => 'Tio Rodrigo', 'email' => 'tio.rodrigo@example.com', 'pases' => 1],
            ['name' => 'Karen Linares', 'email' => 'karen.linares@example.com', 'pases' => 3],
            ['name' => 'Diaz Hernandez', 'email' => 'diaz.hernandez@example.com', 'pases' => 4],
            ['name' => 'Baños Martinez Karlita', 'email' => 'karlita.banos.martinez@example.com', 'pases' => 5],
            ['name' => 'Ferreira Mesa Kati', 'email' => 'kati.ferreira.mesa@example.com', 'pases' => 4],
            ['name' => 'Arellano de la Torre Paco', 'email' => 'paco.arellano.delatorre@example.com', 'pases' => 4],
            ['name' => 'Sandoval Razo Mauro', 'email' => 'mauro.sandoval.razo@example.com', 'pases' => 5],
            ['name' => 'Cortes Borjas Leo', 'email' => 'leo.cortes.borjas@example.com', 'pases' => 5],
            ['name' => 'Familia Magaña Diose', 'email' => 'sdiose.familia.magana@example.com', 'pases' => 2],
            ['name' => 'Eva Maestra', 'email' => 'maestra.eva@example.com', 'pases' => 3],
            ['name' => 'Martinez Vazquez Breisi', 'email' => 'breisi.martinez.vazquez@example.com', 'pases' => 5],
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
