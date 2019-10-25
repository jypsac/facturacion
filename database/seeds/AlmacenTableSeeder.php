<?php

use Illuminate\Database\Seeder;

class AlmacenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('almacen')->insert([
			'id' => 1 ,
			'nombre' => 'Almacen 1',
            'abreviatura' => 'ALM1',
            'direccion' => 'Calle Cuzco nr1 Lima-Lima',
            'responsable' => 'Humberto Garcia',
			'descripcion' => 'Almacen de impresoras',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);

        DB::table('almacen')->insert([
			'id' => 2 ,
			'nombre' => 'Almacen 2',
            'abreviatura' => 'ALM2',
            'direccion' => 'Calle Cuzco nr2 Lima-Lima',
            'responsable' => 'Humberto Garcia',
			'descripcion' => 'Almacen de monitores',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);

        DB::table('almacen')->insert([
			'id' => 3 ,
			'nombre' => 'Almacen 3',
            'abreviatura' => 'ALM3',
            'direccion' => 'Calle Cuzco nr3 Lima-Lima',
            'responsable' => 'Patricio Perz',
			'descripcion' => 'Almacen de equipos a usar ',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
    }
}
