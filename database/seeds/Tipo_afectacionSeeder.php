<?php

use Illuminate\Database\Seeder;

class Tipo_afectacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_afectacion')->insert([
            'id' => 1,
            'codigo' => "10",
            'informacion' => "Gravado - Operación Onerosa",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 2,
            'codigo' => "11",
            'informacion' => "Gravado - Retiro por premio",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 3,
            'codigo' => "12",
            'informacion' => "Gravado - Retiro por donación",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 4,
            'codigo' => "13",
            'informacion' => "Gravado - Retiro",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 5,
            'codigo' => "14",
            'informacion' => "Gravado - Retiro por publicidad",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 6,
            'codigo' => "15",
            'informacion' => "Gravado - Bonificaciones",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 7,
            'codigo' => "16",
            'informacion' => "Gravado - Retiro por entrega a trabajadores",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 8,
            'codigo' => "17",
            'informacion' => "Gravado - IVAP",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 9,
            'codigo' => "20",
            'informacion' => "Exonerado - Operación Onerosa",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 10,
            'codigo' => "21",
            'informacion' => "Exonerado - Transferencia Gratuita",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 11,
            'codigo' => "30",
            'informacion' => "Inafecto - Operacion Onerosa",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 12,
            'codigo' => "31",
            'informacion' => "Inafecto - Retiro por Bonificación",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 13,
            'codigo' => "32",
            'informacion' => "Inafecto - Retiro",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 14,
            'codigo' => "33",
            'informacion' => "Inafecto - Retiro por Muestras Médicas",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 15,
            'codigo' => "34",
            'informacion' => "Inafecto - Retiro por Convenio Colectivo",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 16,
            'codigo' => "35",
            'informacion' => "Inafecto - Retiro por premio",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 17,
            'codigo' => "36",
            'informacion' => "Inafecto - Retiro por publicidad",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_afectacion')->insert([
            'id' => 18,
            'codigo' => "40",
            'informacion' => "Exportación",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
