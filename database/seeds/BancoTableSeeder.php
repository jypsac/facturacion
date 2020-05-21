<?php

use Illuminate\Database\Seeder;

class BancoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banco')->insert([
			'id' => 1 ,
			'nombre' => 'BCP',
			'numero_dolares' =>"000000000000" ,
			'numero_soles' => '000000000000',
			'foto' => "bcp.png" ,
			'estado' => "0" ,
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
		DB::table('banco')->insert([
			'id' => 2 ,
			'nombre' => 'Interbank',
			'numero_dolares' =>"000000000000" ,
			'numero_soles' => '000000000000',
			'foto' => "interbank.jpg" ,
			'estado' => "0" ,
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
		DB::table('banco')->insert([
			'id' => 3 ,
			'nombre' => 'Scotiabank',
			'numero_dolares' =>"000000000000" ,
			'numero_soles' => '000000000000',
			'foto' => "scotiabank.jpg" ,
			'estado' => "0" ,
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
		DB::table('banco')->insert([
			'id' => 4 ,
			'nombre' => 'BBVA',
			'numero_dolares' =>"000000000000" ,
			'numero_soles' => '000000000000',
			'foto' => "bbva.png" ,
			'estado' => "0" ,
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
    }
}
