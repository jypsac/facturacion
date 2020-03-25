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
            'precio' => 112,
            'cantidad' => 200,
            'estado' => 1,
            
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('kardex_entrada_registro')->insert([
            'id' => 2 ,
            'kardex_entrada_id' => 1,
            'producto_id' => 2,
            'cantidad_inicial' => 150,
            'precio' => 14322,
            'cantidad' => 150,
            'estado' => 1,
            
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('kardex_entrada_registro')->insert([
            'id' => 3 ,
            'kardex_entrada_id' => 1,
            'producto_id' => 3,
            'cantidad_inicial' => 100,
            'precio' => 1122,
            'cantidad' => 100,
            'estado' => 1,
            
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        
    }
}
