<?php

use Illuminate\Database\Seeder;

class KardexEntradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kardex_entrada')->insert([
            'id' => 0 ,
            'codigo_guia' => 'GE001-00000000',
            'motivo_id' => 1,
            'provedor_id' => 1,
            'categoria_id' => 1,
            'almacen_id' => 1,
            'moneda_id' => 1,
            'guia_remision' => "00000",
            'factura' => "F001-0000000",
            'informacion' => "informacion de prueba 1",
            'estado' => 1,
            'user_id' => 1,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);

        // DB::table('kardex_entrada')->insert([
        //     'id' => 2 ,
        //     'codigo_guia' => 'GE002-00000001',
        //     'motivo_id' => 1,
        //     'provedor_id' => 1,
        //     'categoria_id' => 1,
        //     'almacen_id' => 2,
        //     'moneda_id' => 1,
        //     'guia_remision' => "00002",
        //     'factura' => "F001-0000002",
        //     'informacion' => "informacion de prueba 2",
        //     'estado' => 1,
        //     'user_id' => 1,
        //     'created_at' => date('2020-08-01 00:00:00'),
        //    	'updated_at' => date('2020-08-01 00:00:00')
        // ]);

        // DB::table('kardex_entrada')->insert([
        //     'id' => 3 ,
        //     'codigo_guia' => 'GE002-00000002',
        //     'motivo_id' => 1,
        //     'provedor_id' => 1,
        //     'categoria_id' => 1,
        //     'almacen_id' => 3,
        //     'moneda_id' => 2,
        //     'guia_remision' => "00003",
        //     'factura' => "F001-0000003",
        //     'informacion' => "informacion de prueba 3",
        //     'estado' => 1,
        //     'user_id' => 1,
        //     'created_at' => date('2020-08-01 00:00:00'),
        //    	'updated_at' => date('2020-08-01 00:00:00')
        // ]);


    }
}
