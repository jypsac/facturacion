<?php

use Illuminate\Database\Seeder;

class FacturacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('facturacion')->insert([
			'id' => 1 ,
			'codigo_fac' => '001',
			'cliente' => 'Cristofer Pendeivis',
			'observacion' => 'Compras medienate la cotizacion, de la Fecha de ayer ',
			'created_at' => date('2020-03-12 00:00:00'),
           	'updated_at' => date('2020-03-12 00:00:00')
		]);
    }
}
