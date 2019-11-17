<?php

use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidad_medida')->insert([
			'id' => 1 ,
			'simbolo' => 'BOL',
			'medida' => 'Bolsa',
			'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
		]);
       
        DB::table('unidad_medida')->insert([
            'id' => 2,
            'simbolo' => 'CTO',
            'medida' => 'Ciento',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 3 ,
            'simbolo' => 'DOC',
            'medida' => 'Docena',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 4 ,
            'simbolo' => 'FAR',
            'medida' => 'Fardo',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 5 ,
            'simbolo' => 'GLNES',
            'medida' => 'galones',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 6 ,
            'simbolo' => 'JGO',
            'medida' => 'juego',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 7 ,
            'simbolo' => 'KL',
            'medida' => 'Kilos',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 8 ,
            'simbolo' => 'KT',
            'medida' => 'Kit',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 9 ,
            'simbolo' => 'LB',
            'medida' => 'Libras',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 10 ,
            'simbolo' => 'M',
            'medida' => 'Metros',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 11,
            'simbolo' => 'M2',
            'medida' => 'Metros Cuadrados',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 12,
            'simbolo' => 'MLL',
            'medida' => 'Millar',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 13,
            'simbolo' => 'PKG',
            'medida' => 'Paquete',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 14,
            'simbolo' => 'PAR',
            'medida' => 'Par',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 15,
            'simbolo' => 'PZA',
            'medida' => 'Pieza',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 16,
            'simbolo' => 'ROL',
            'medida' => 'Rollo',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 17,
            'simbolo' => 'SET',
            'medida' => 'Set',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('unidad_medida')->insert([
            'id' => 18,
            'simbolo' => 'UD',
            'medida' => 'Unidades',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
         DB::table('unidad_medida')->insert([
            'id' => 19 ,
            'simbolo' => 'CAJ',
            'medida' => 'Caja',
            'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
