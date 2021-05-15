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
            'precio_nacional' => 50.00,
            'precio_extranjero' => 13.59,
            'cantidad' => 100,
            'cambio' => 3.68,
            'estado' => 1,
            'estado_devolucion' => NULL,
            'almacen_id' => 1,
            'tipo_registro_id' => 1,
            'created_at' => date('2021-03-08 17:05:26'),
           	'updated_at' => date('2021-03-08 17:05:26')
        ]);
         DB::table('kardex_entrada_registro')->insert([
            'id' =>2 ,
            'kardex_entrada_id' => 1,
            'producto_id' => 2,
            'cantidad_inicial' => 50,
            'precio_nacional' => 25.00,
            'precio_extranjero' =>6.79,
            'cantidad' => 50,
            'cambio' => 3.68,
            'estado' => 1,
            'estado_devolucion' => NULL,
            'almacen_id' => 1,
            'tipo_registro_id' => 1,
            'created_at' => date('2021-03-08 17:05:26'),
           	'updated_at' => date('2021-03-08 17:05:26')
        ]);
        // DB::table('kardex_entrada_registro')->insert([
        //     'id' => 3 ,
        //     'kardex_entrada_id' => 2,
        //     'producto_id' => 1,
        //     'cantidad_inicial' => 25,
        //     'precio_nacional' => 50.00,
        //     'precio_extranjero' => 13.55,
        //     'cantidad' => 0,
        //     'cambio' => 3.69,
        //     'estado' => 0,
        //     'estado_devolucion' => NULL,
        //     'tipo_registro_id' => 1,
        //     'created_at' => date('2021-03-08 17:05:51'),
        //    	'updated_at' => date('2021-03-08 17:05:51')
        // ]);
        // DB::table('kardex_entrada_registro')->insert([
        //     'id' => 4 ,
        //     'kardex_entrada_id' => 2,
        //     'producto_id' => 2,
        //     'cantidad_inicial' => 25,
        //     'precio_nacional' => 125.00,
        //     'precio_extranjero' => 33.88,
        //     'cantidad' => 0,
        //     'cambio' => 3.69,
        //     'estado' => 0,
        //     'estado_devolucion' => NULL,
        //     'tipo_registro_id' => 1,
        //     'created_at' => date('2021-03-08 17:05:51'),
        //    	'updated_at' => date('2021-03-08 17:05:51')
        // ]);
        // DB::table('kardex_entrada_registro')->insert([
        //     'id' => 5 ,
        //     'kardex_entrada_id' => 3,
        //     'producto_id' => 1,
        //     'cantidad_inicial' => 100,
        //     'precio_nacional' => 0,
        //     'precio_extranjero' => 0,
        //     'cantidad' => 100,
        //     'cambio' => 3.69,
        //     'estado' => 1,
        //     'estado_devolucion' => NULL,
        //     'tipo_registro_id' => 2,
        //     'created_at' => date('2021-03-08 17:06:24'),
        //    	'updated_at' => date('2021-03-08 17:06:24')
        // ]);
        // DB::table('kardex_entrada_registro')->insert([
        //     'id' => 6 ,
        //     'kardex_entrada_id' => 3,
        //     'producto_id' => 2,
        //     'cantidad_inicial' => 100,
        //     'precio_nacional' => 0,
        //     'precio_extranjero' =>0,
        //     'cantidad' => 100,
        //     'cambio' => 3.69,
        //     'estado' => 1,
        //     'estado_devolucion' => NULL,
        //     'tipo_registro_id' => 2,
        //     'created_at' => date('2021-03-08 17:06:24'),
        //    	'updated_at' => date('2021-03-08 17:06:24')
        // ]);
        // //stock productos
        // DB::table('stock_productos')->insert([
        //     'id' => 1 ,
        //     'producto_id' => 1,
        //     'stock' => 375,
        //     'precio_nacional' => NULL,
        //     'precio_extranjero' => NULL,
        //     'created_at' => date('2021-03-08 17:05:26'),
        //    	'updated_at' => date('2021-03-08 17:05:26')
        // ]);
        // DB::table('stock_productos')->insert([
        //     'id' => 2 ,
        //     'producto_id' => 2,
        //     'stock' => 1625,
        //     'precio_nacional' => NULL,
        //     'precio_extranjero' => NULL,
        //     'created_at' => date('2021-03-08 17:05:26'),
        //    	'updated_at' => date('2021-03-08 17:05:26')
        // ]);
        // DB::table('kardex_entrada_registro')->insert([
        //     'id' => 8 ,
        //     'kardex_entrada_id' => 3,
        //     'producto_id' => 4,
        //     'cantidad_inicial' => 50,
        //     'precio_nacional' => 288.80,
        //     'precio_extranjero' => 80.00,
        //     'cantidad' => 50,
        //     'estado' => 1,
        //     'cambio' => 3.61,
        //     'created_at' => date('2020-08-01 00:00:00'),
        //    	'updated_at' => date('2020-08-01 00:00:00')
        // ]);
    }
}
