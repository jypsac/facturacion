
<?php

use Illuminate\Database\Seeder;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marcas')->insert([
			'id' => 1 ,
			'nombre' => 'HP' ,
			'codigo' => '00001',
			'abreviatura' => 'HP',
			'nombre_empresa' => 'Hewlett-Packard',
			'descripcion' => 'más conocida como HP, fue una empresa de tecnología estadounidense',
			'imagen'=>'1574999296hp.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 2 ,
			'nombre' => 'AMD' ,
			'codigo' => '00002',
			'abreviatura' => 'AMD',
			'nombre_empresa' => 'Advanced Micro Devices',
			'descripcion' => 'es una compañía estadounidense de semiconductores establecida en Santa Clara, California, que desarrolla procesadores de cómputo y productos tecnológicos relacionados para el mercado de consumo.',
			'imagen'=>'1575001776amd.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
		DB::table('marcas')->insert([
			'id' => 3 ,
			'nombre' => 'MSI' ,
			'codigo' => '00003',
			'abreviatura' => 'MSI',
			'nombre_empresa' => 'Micro-Star International',
			'descripcion' => ' es una corporación multinacional taiwanesa de tecnología de la información con sede en Nuevo Taipei, Taiwán (República de China). Diseña, desarrolla y proporciona equipo informático, productos y servicios relacionados',
			'imagen'=>'1575059774msi.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 4 ,
			'nombre' => 'ADVANCE' ,
			'codigo' => '00004',
			'abreviatura' => 'ADV',
			'nombre_empresa' => 'ADVANCE',
			'descripcion' => 'empresa de tecnología con más de ocho años de presencia en Latinoamérica y el mundo',
			'imagen'=>'1575060799advance.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 5 ,
			'nombre' => 'WESTER DIGITAL' ,
			'codigo' => '00005',
			'abreviatura' => 'WD',
			'nombre_empresa' => 'Western Digital Corporation',
			'descripcion' => 'es un fabricante mundial de discos duros, con una larga historia en la industria electrónica, es un fabricante de circuitos integrados y de productos de almacenamiento, actualmente es el primer fabricante de discos duros por delante de Seagate',
			'imagen'=>'1575061272wd.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 6 ,
			'nombre' => 'LENOVO' ,
			'codigo' => '00006',
			'abreviatura' => 'LE',
			'nombre_empresa' => 'Lenovo Group, Ltd',
			'descripcion' => 'es una compañía multinacional de tecnología china, fabricante de productos electrónicos, ordenadores, tabletas y smartphones.',
			'imagen'=>'1575061430lenovo.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 7 ,
			'nombre' => 'D-LINK' ,
			'codigo' => '00007',
			'abreviatura' => 'DLINK',
			'nombre_empresa' => 'D-Link Corporation',
			'descripcion' => 'es un proovedor global con sede en Taipei, Taiwan, cuyo principal negocio son las soluciones de redes y comunicaciones para consumidores y empresas',
			'imagen'=>'1575061561dlink.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 8 ,
			'nombre' => 'TOSHIBA' ,
			'codigo' => '00008',
			'abreviatura' => 'TOSH',
			'nombre_empresa' => 'Toshiba',
			'descripcion' => ' es una compañía japonesa, con sede en Tokio, dedicada a la manufactura de aparatos eléctricos y electrónicos.',
			'imagen'=>'1575062143toshi.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 9 ,
			'nombre' => 'KIGSTON' ,
			'codigo' => '00009',
			'abreviatura' => 'KG',
			'nombre_empresa' => 'Kingston Technology Corporation',
			'descripcion' => 'es un fabricante estadounidense de productos de memorias de ordenadores',
			'imagen'=>'1575062262kingston.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
		DB::table('marcas')->insert([
			'id' => 10 ,
			'nombre' => 'NEXXT' ,
			'codigo' => '00010',
			'abreviatura' => 'NEX',
			'nombre_empresa' => 'Nexxt Solutions Connectivity',
			'descripcion' => 'desarrolla productos y soluciones que permiten conectar a gente y dispositivos, generando nuevas experiencias de conectividad inteligente',
			'imagen'=>'1575062629next.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 11 ,
			'nombre' => 'HALION' ,
			'codigo' => '00011',
			'abreviatura' => 'HAL',
			'nombre_empresa' => 'Halion International S.A',
			'descripcion' => 'empresa dedicada a la venta de parlantes ,teclados ,mous ,auriculares y otros accesorios',
			'imagen'=>'1575062932halion.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 12 ,
			'nombre' => 'AVATEC' ,
			'codigo' => '00012',
			'abreviatura' => 'AVA',
			'nombre_empresa' => 'ITD',
			'descripcion' => 'empresa comercializadora de partes, accesorios y suministros de cómputo para consumidores, empresas e instituciones',
			'imagen'=>'1575063072ava.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 13 ,
			'nombre' => 'EPSON' ,
			'codigo' => '00013',
			'abreviatura' => 'EP',
			'nombre_empresa' => 'Seiko Epson Corporation',
			'descripcion' => 'es una compañía japonesa y uno de los mayores fabricantes del mundo de impresoras de inyección de tinta, matricial y de impresoras láser, escáneres, ordenadores de escritorio, proyectores, home cinema, televisores, robots, equipamiento de automatismo industrial, TPV, máquinas registradoras, ordenadores portátiles, circuitos integrados, componentes de LCD y otros componentes electrónicos.',
			'imagen'=>'1575063287Epson.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 14 ,
			'nombre' => 'DELL' ,
			'codigo' => '00014',
			'abreviatura' => 'DEL',
			'nombre_empresa' => 'Dell Technologies',
			'descripcion' => 'es una compañía multinacional estadounidense establecida en Round Rock (Texas), la cual desarrolla, fabrica, vende y da soporte a computadoras personales, servidores, switches de red, programas informáticos, periféricos y otros productos relacionados con la tecnología.',
			'imagen'=>'1575063406dell.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);

		DB::table('marcas')->insert([
			'id' => 15 ,
			'nombre' => 'INTEL' ,
			'codigo' => '00015',
			'abreviatura' => 'INT',
			'nombre_empresa' => 'Intel Corporation',
			'descripcion' => 'es la creadora de la serie de procesadores x86, los procesadores más comúnmente encontrados en la mayoría de las computadoras personales',
			'imagen'=>'1575063475intel.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
		DB::table('marcas')->insert([
			'id' => 16 ,
			'nombre' => 'CANON' ,
			'codigo' => '00016',
			'abreviatura' => 'CANON',
			'nombre_empresa' => 'Intel Corporation',
			'descripcion' => 'es la creadora de la serie de procesadores x86, los procesadores más comúnmente encontrados en la mayoría de las computadoras personales',
			'imagen'=>'1575063475can.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
    
}
