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
            'id' => 1 ,
            'motivo_id' => 1,
            'provedor_id' => 1,
            'categoria_id' => 1,
            'almacen_id' => 1,
            'moneda_id' => 1,
            'guia_remision' => "ee1",
            'factura' => "1",
            'informacion' => "12",
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}
