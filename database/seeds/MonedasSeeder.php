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
			'principal' => 1,
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
       DB::table('monedas')->insert([
            'id' => 2 ,
            'nombre' => "Dolares",
            'simbolo' => "$",
            'codigo' => "USD",
            'pais' => "Estados Unidos",
            'descripcion' => 'Moneda Principal Estados Unidos',
            'principal' => 0,
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
       DB::table('monedas')->insert([
            'id' =>3 ,
            'nombre' => "Euros",
            'simbolo' => "€",
            'codigo' => "EUR",
            'pais' => "España",
            'descripcion' => 'Moneda Principal Española',
            'principal' => 0,
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
