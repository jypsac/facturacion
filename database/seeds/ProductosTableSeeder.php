<?php

use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('productos')->insert([
    		'id' => 1 ,
    		'codigo_producto' => 'RE-0001',
    		'codigo_original' => 'R900930035',
    		'nombre' =>'Valvula direccional' ,
    		'utilidad' => '30',
    		'descuento1' => "0",
    		'descuento2' => "0",
    		'descuento_maximo' => "0",
    		'descripcion' => 'pues es un buen producto',
    		'origen' => "Importado",
    		'garantia' => '12 meses',
    		'peso' => '0 kl',
    		'stock_minimo' => '2',
    		'stock_maximo' => '12',
    		'foto' => '15964884424WRAEW60.jpg',
    		'categoria_id' =>"2" ,
    		'familia_id' => '8',
    		'marca_id' => "1" ,
    		'unidad_medida_id' => "2",
    		'estado_id' => "1",
    		'estado_anular'=>'1',
    		'created_at' => '2019-10-30 11:36:57',
    		'updated_at' => "2019-10-30 11:36:57" ,
    	]);
    	// DB::table('productos')->insert([
    	// 	'id' => 2 ,
    	// 	'codigo_producto' => 'HP-0001',
    	// 	'codigo_original' => 'AS-WW-0021',
    	// 	'nombre' =>'HP LAPTOP 14-CM0007LA' ,
    	// 	'utilidad' => '30',
    	// 	'descuento1' => "10",
    	// 	'descuento2' => "10",
    	// 	'descuento_maximo' => "50",
    	// 	'descripcion' => 'AMD Ryzen™ 3 2200UN.° de núcleos de CPU2N.° de subprocesos4N.° de núcleos de GPU3Reloj base2.5GHzReloj de aumento máx.3.4GHzCaché L1 total384KBCaché L2 total1MBCaché L3 total4MBWindows 10 edición de 64·bits ',
    	// 	'origen' => "Importado",
    	// 	'garantia' => '51 dias',
    	// 	'peso' => '15 kl',
    	// 	'stock_minimo' => '5',
    	// 	'stock_maximo' => '100',
    	// 	'foto' => 'sin_foto.jpg',
    	// 	'categoria_id' =>"3" ,
    	// 	'familia_id' => '9',
    	// 	'marca_id' => "1" ,
    	// 	'unidad_medida_id' => "9",
    	// 	'estado_id' => "1",
    	// 	'estado_anular'=>'1',
    	// 	'created_at' => '2019-10-30 11:36:57',
    	// 	'updated_at' => "2019-10-30 11:36:57" ,
    	// ]);


    	// DB::table('productos')->insert([
    	// 	'id' => 3 ,
    	// 	'codigo_producto' => 'ADVA-0001',
    	// 	'codigo_original' => 'EE-ZZ-0002',
    	// 	'nombre' =>'Celuar Xiaomi Mi8 Mi 8 6GB RAM 128GB ROM - Negro' ,
    	// 	'utilidad' => '40',
    	// 	'descuento1' => "10",
    	// 	'descuento2' => "10",
    	// 	'descuento_maximo' => "50",
    	// 	'descripcion' => 'OC snapdragon 845, adreno 630
    	// 	monitor 6.21 pulgadas 2248x1080 FHD + pantalla, 402 PPI
    	// 	RAM 6GB
    	// 	ROM 128 GB, no es compatible con tarjeta de memoria,
    	// 	cámara frontal 20M',
    	// 	'origen' => "NAcional",
    	// 	'garantia' => '5 dias',
    	// 	'peso' => '15 kl',
    	// 	'stock_minimo' => '5',
    	// 	'stock_maximo' => '100',
    	// 	'foto' => 'sin_foto.jpg',
    	// 	'categoria_id' =>"1" ,
    	// 	'familia_id' => '8',
    	// 	'marca_id' => "10" ,
    	// 	'unidad_medida_id' => "11",
    	// 	'estado_id' => "1",
    	// 	'estado_anular'=>'1',
    	// 	'created_at' => '2019-10-30 11:36:57',
    	// 	'updated_at' => "2019-10-30 11:36:57" ,
    	// ]);
    }
}