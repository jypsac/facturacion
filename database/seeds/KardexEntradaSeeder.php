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
        // GD-000001 DISTRIBUCION
        // GE-000001 ENTRADA
        // GTA-000001 TRASLADO DE ALMACEN
        DB::table('kardex_entrada')->insert([
            'id' => 0 ,
            'codigo_guia' => 'GE-00000001',
            'motivo_id' => 1,
            'provedor_id' => 1,
            'categoria_id' => 2,
            'almacen_id' => 1,
            'moneda_id' => 1,
            'guia_remision' => "0",
            'factura' => "0",
            'informacion' => "informacion de productos al almacen",
            'estado' => 1,
            'tipo_registro_id' => 1,
            'user_id' => 1,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);

        DB::table('kardex_entrada')->insert([
            'id' => 2 ,
            'codigo_guia' => 'GE-00000002',
            'motivo_id' => 1,
            'provedor_id' => 1,
            'categoria_id' => 2,
            'almacen_id' => 1,
            'moneda_id' => 1,
            'guia_remision' => "0",
            'factura' => "0",
            'informacion' => "informacion de productos al almacen",
            'estado' => 1,
            'tipo_registro_id' => 1,
            'user_id' => 1,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);

        DB::table('kardex_entrada')->insert([
            'id' => 3 ,
            'codigo_guia' => 'GE-00000003',
            'motivo_id' => 1,
            'provedor_id' => 1,
            'categoria_id' => 2,
            'almacen_id' => 1,
            'moneda_id' => 1,
            'guia_remision' => "0",
            'factura' => "0",
            'informacion' => "informacion de productos al almacen",
            'estado' => 1,
            'tipo_registro_id' => 1,
            'user_id' => 1,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);


    }
}
