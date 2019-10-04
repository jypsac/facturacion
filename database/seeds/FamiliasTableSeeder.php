<?php

use Illuminate\Database\Seeder;

class FamiliasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('familias')->insert([
			'id' => 1 ,
			'codigo' => '001',
			'descripcion' => 'TABLETS',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
		DB::table('familias')->insert([
			'id' => 2 ,
			'codigo' => '002',
			'descripcion' => 'SERVIDORES',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 3 ,
			'codigo' => '003',
			'descripcion' => 'PERIFERICOS',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 4 ,
			'codigo' => '004',
			'descripcion' => 'GPS - GESTION DE FLOTA',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 5 ,
			'codigo' => '005',
			'descripcion' => 'PORTATILES',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 6 ,
			'codigo' => '006',
			'descripcion' => 'SUMINISTRO',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 7 ,
			'codigo' => '007',
			'descripcion' => 'DOMINIO HOSTING',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 8 ,
			'codigo' => '008',
			'descripcion' => 'NOVEDADES TECNOLOGICAS',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 9 ,
			'codigo' => '009',
			'descripcion' => 'COMPUTADORAS DE ESCRITORIO',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 10 ,
			'codigo' => '010',
			'descripcion' => 'IMPRESORAS',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 11 ,
			'codigo' => '011',
			'descripcion' => 'REDES Y COMUNICACIONES',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 12 ,
			'codigo' => '012',
			'descripcion' => 'SEGURIDAD ELECTRONICA',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 13 ,
			'codigo' => '013',
			'descripcion' => 'SEGURIDAD INFORMATICA',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('familias')->insert([
			'id' => 14 ,
			'codigo' => '014',
			'descripcion' => 'EQUIPOS INALAMBRICOS',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}
