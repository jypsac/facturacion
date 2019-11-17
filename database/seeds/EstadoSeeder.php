<?php

use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado')->insert([
			'id' => 1 ,
			'nombre' =>'ACTIVO' ,
			'descripcion' => 'Dicho Articulo se mantiene en actividad',
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
		 DB::table('estado')->insert([
			'id' => 2 ,
			'nombre' =>'DESACTIVO' ,
			'descripcion' => 'Dicho Articulo se mantiene Desactivado',
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
		 DB::table('estado')->insert([
			'id' => 3 ,
			'nombre' =>'DESCONTINUADO' ,
			'descripcion' => 'Dicho Articulo se mantiene en DESUSO',
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
    }
}
