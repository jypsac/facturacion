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
			'cod_producto' => 'EP-0001',
			'nombre' =>'Laptop Samsung Galaxy Book 12\"' ,
			'utilidad' => '10',
			'descuento' => "10" ,
			'descuento2' => "20",
			'unidad_medida' => "Unidad" ,
			'producto_estado' => 'Activo',
			'descripcion' => 'Procesador Intel Core i5-7th Gen de Dual-Core a 3,1 GHz
							Memoria RAM de 4GB - Almacenamiento SSD de 128GB
							Pantalla multitáctil de 12" x 2160 x 1440
							Gráficos integrados Intel HD
							Lector de tarjetas de medios microSDXC
							Wi-Fi 802.11ac de doble banda - Bluetooth 4.1
							USB 3.1 Tipo-C
							Windows 10 Home
							SOLO SE EMITE BOLETA DE VENTA',
			'origen' => "Importado",
			'precio' => '20' ,
			'foto' => '',
			'categoria_id' =>"2" ,
			'familia_id' => '8',
			'marca_id' => "13" ,
			'monedas_id' => "2",
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
		DB::table('productos')->insert([
			'id' => 2 ,
			'cod_producto' => 'HP-0002',
			'nombre' =>'HP LAPTOP 14-CM0007LA' ,
			'utilidad' => '30',
			'descuento' => "0" ,
			'descuento2' => "0",
			'unidad_medida' => "Unidad" ,
			'producto_estado' => 'Activo',
			'descripcion' => 'AMD Ryzen™ 3 2200UN.° de núcleos de CPU2N.° de subprocesos4N.° de núcleos de GPU3Reloj base2.5GHzReloj de aumento máx.3.4GHzCaché L1 total384KBCaché L2 total1MBCaché L3 total4MBWindows 10 edición de 64·bits           
				Velocidad máxima de memoria2400MHzTipo de memoriaDDR4Canales de memoria2
				     Modelo de gráficosRadeon™                      Vega 3 Graphics
				Conexion Inalambrica Wi-Fi 802.11b/g/n (1x1) y Bluetooth 4.2
				Puertos de USB x 3
				Puertos de HDMI x 1
				Combinación de auriculares y micrófono
				Lector de tarjeta de memoria :Lector de tarjetas SD multimedia de múltiples formatos',
			'origen' => "Importado",
			'precio' => '130' ,
			'foto' => '',
			'categoria_id' =>"3" ,
			'familia_id' => '9',
			'marca_id' => "12" ,
			'monedas_id' => "3",
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);


		DB::table('productos')->insert([
			'id' => 3 ,
			'cod_producto' => 'ADVA-0002',
			'nombre' =>'Celuar Xiaomi Mi8 Mi 8 6GB RAM 128GB ROM - Negro' ,
			'utilidad' => '40',
			'descuento' => "5" ,
			'descuento2' => "20",
			'unidad_medida' => "Unidad" ,
			'producto_estado' => 'Desactivo',
			'descripcion' => 'OC snapdragon 845, adreno 630
								monitor 6.21 pulgadas 2248x1080 FHD + pantalla, 402 PPI
								RAM 6GB
								ROM 128 GB, no es compatible con tarjeta de memoria,
								cámara frontal 20MP
								cámara trasera
								cámara gran angular, 12MP, OIS de 4 ejes, F / 1.8
								cámara de teleobjetivo, 12MP, F / 2.6
								batería 3400mah (typ) / 3300mah (min)
								Global version',
			'origen' => "NAcional",
			'precio' => '230' ,
			'foto' => '',
			'categoria_id' =>"1" ,
			'familia_id' => '8',
			'marca_id' => "10" ,
			'monedas_id' => "1",
			'created_at' => '2019-10-30 11:36:57',
			'updated_at' => "2019-10-30 11:36:57" ,
		]);
      

         }
}