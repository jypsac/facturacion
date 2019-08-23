<?php

use Illuminate\Database\Seeder;

class MonedasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('monedas')->insert([
			'id' => 1 ,
			'nombre' => "soles",
			'simbolo' => "S/",
			'codigo' => "PEN",
			'pais' => "Peru",
			'descripcion' => 'Moneda Principal Peruana',
			'principal' => 0,
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}
