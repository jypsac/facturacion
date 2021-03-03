<?php

use Illuminate\Database\Seeder;

class TipoRegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_registro')->insert([
			'id' => 1 ,
			'nombre' => 'Entrada',
			'informacion' => 'entrada de nuevos productos kardex al almacen principal',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
		]);
       
        DB::table('tipo_registro')->insert([
            'id' => 2,
            'nombre' => 'Traslado de almacen',
			'informacion' => 'tarslado del almacen secundario a otro o principal',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_registro')->insert([
            'id' => 3 ,
            'nombre' => 'Distribucion',
			'informacion' => 'Distribuye del almacen principal a las sucursales',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
