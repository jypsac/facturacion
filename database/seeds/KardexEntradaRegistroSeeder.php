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
            'cantidad_inicial' => 100,
            'precio_nacional' => 10,
            'precio_extranjero' => 2.77,
            'cantidad' => 100,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
        DB::table('kardex_entrada_registro')->insert([
            'id' => 2 ,
            'kardex_entrada_id' => 1,
            'producto_id' => 2,
            'cantidad_inicial' => 100,
            'precio_nacional' => 20,
            'precio_extranjero' => 5.54,
            'cantidad' => 100,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
        DB::table('kardex_entrada_registro')->insert([
            'id' => 3 ,
            'kardex_entrada_id' => 2,
            'producto_id' => 3,
            'cantidad_inicial' => 100,
            'precio_nacional' => 30,
            'precio_extranjero' => 8.31,
            'cantidad' => 100,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
        DB::table('kardex_entrada_registro')->insert([
            'id' => 4 ,
            'kardex_entrada_id' => 2,
            'producto_id' => 2,
            'cantidad_inicial' => 100,
            'precio_nacional' => 40,
            'precio_extranjero' => 11.08,
            'cantidad' => 100,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
        DB::table('kardex_entrada_registro')->insert([
            'id' => 5 ,
            'kardex_entrada_id' => 3,
            'producto_id' => 1,
            'cantidad_inicial' => 50,
            'precio_nacional' => 180.50,
            'precio_extranjero' => 50.00,
            'cantidad' => 50,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
        DB::table('kardex_entrada_registro')->insert([
            'id' => 6 ,
            'kardex_entrada_id' => 3,
            'producto_id' => 2,
            'cantidad_inicial' => 50,
            'precio_nacional' => 216.60,
            'precio_extranjero' => 60.00,
            'cantidad' => 50,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
        DB::table('kardex_entrada_registro')->insert([
            'id' => 7 ,
            'kardex_entrada_id' => 3,
            'producto_id' => 3,
            'cantidad_inicial' => 50,
            'precio_nacional' => 252.70,
            'precio_extranjero' => 70.00,
            'cantidad' => 50,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
        DB::table('kardex_entrada_registro')->insert([
            'id' => 8 ,
            'kardex_entrada_id' => 3,
            'producto_id' => 2,
            'cantidad_inicial' => 50,
            'precio_nacional' => 288.80,
            'precio_extranjero' => 80.00,
            'cantidad' => 50,
            'estado' => 1,
            'cambio' => 3.61,
            'created_at' => date('2020-08-01 00:00:00'),
           	'updated_at' => date('2020-08-01 00:00:00')
        ]);
    }
}
