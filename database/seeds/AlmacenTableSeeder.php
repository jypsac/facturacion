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
<<<<<<< HEAD
      DB::table('almacen')->insert([
       'id' => 1 ,
       'nombre' => 'Almacen 1',
       'abreviatura' => 'ALM1',
       'codigo_sunat' => '1',
       'direccion' => 'Calle Cuzco nr1 Lima-Lima',
       'responsable' => '1',
       'descripcion' => 'Almacen de perritos',
       'cod_fac' => '13',
       'cod_bol' => '34',
       'cod_guia' => '89',
       'estado' => '0',
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
      DB::table('almacen')->insert([
       'id' => 2 ,
       'nombre' => 'Almacen 2',
       'abreviatura' => 'ALM2',
       'codigo_sunat' => '2',
       'direccion' => 'Calle Cuzco nr1 Lima-Lima',
       'responsable' => '2',
       'descripcion' => 'Almacen de impresoras',
       'cod_fac' => '4',
       'cod_bol' => '21',
       'cod_guia' => '23',
       'estado' => '0',
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
=======
        DB::table('almacen')->insert([
			'id' => 1 ,
			'nombre' => 'Almacen 1',
      'abreviatura' => 'ALM1',
      'codigo_sunat' => '1',
      'direccion' => 'Calle Cuzco nr1 Lima-Lima',
      'responsable' => 'Humberto Garcia',
      'descripcion' => 'Almacen de impresoras',
			'estado' => '0',
      'cod_fac' => '100',
      'cod_bol' => '200',
      'cod_guia' => '10',
			'created_at' => date('2019-08-01 00:00:00'),
      'updated_at' => date('2019-08-01 00:00:00')
        ]);
>>>>>>> 4088f19749687ddbc6b05d69d5f53139b1bbb78f

   //      DB::table('almacen')->insert([
			// 'id' => 2 ,
			// 'nombre' => 'Almacen 2',
   //          'abreviatura' => 'ALM2',
    //    'codigo_sunat' => '2',
   //          'direccion' => 'Calle Cuzco nr2 Lima-Lima',
   //          'responsable' => 'Humberto Garcia',
			// 'descripcion' => 'Almacen de monitores',
   //          'estado' => '0',
			// 'created_at' => date('2019-08-01 00:00:00'),
   //         	'updated_at' => date('2019-08-01 00:00:00')
   //      ]);

   //      DB::table('almacen')->insert([
			// 'id' => 3 ,
			// 'nombre' => 'Almacen 3',
   //          'abreviatura' => 'ALM3',
    //    'codigo_sunat' => '3',
   //          'direccion' => 'Calle Cuzco nr3 Lima-Lima',
   //          'responsable' => 'Patricio Perz',
			// 'descripcion' => 'Almacen de equipos a usar ',
   //          'estado' => '0',
			// 'created_at' => date('2019-08-01 00:00:00'),
   //         	'updated_at' => date('2019-08-01 00:00:00')
   //      ]);

    }
  }
