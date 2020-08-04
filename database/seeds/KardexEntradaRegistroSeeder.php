<?php

use Illuminate\Database\Seeder;

class KardexEntradaRegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kardex_entrada_registro')->insert([
            'id' => 1 ,
            'kardex_entrada_id' => 1,
            'producto_id' => 1,
            'cantidad_inicial' => 200,
            'precio' => 11,
            'cantidad' => 200,
            'estado' => 1,

            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
