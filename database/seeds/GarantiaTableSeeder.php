<?php

use Illuminate\Database\Seeder;

class GarantiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('garantia_guia_ingreso')->insert([
			'id' => 1 ,
			'motivo' => 'TECNICO',
			'fecha' => date('2019-08-01'),
			'orden_servicio' => 'EQQP-75675',
			'estado' => 1,
			'egresado'=> 0,
			'asunto' => 'GARANTIA',
			'nombre_equipo' => 'EPSON L3110',
			'numero_serie' => 'X645008531',
			'codigo_interno' => 'C0004393',
			'fecha_compra' => date('2019-08-01'),
			'descripcion_problema' => 'Falla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente lorem Falla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente lorem',

			'revision_diagnostico' => 'FFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremalla Detectada Falla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente lorem: correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremalla Detectada Falla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente lorem:',
			'estetica' => 'Se observa en buen estado, Ingresa equipo con caja Falla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremSe observa en buen estado, Ingresa equipo con caja Falla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremSe observa en buen estado, Ingresa equipo con caja Falla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente loremFalla Reportada: No toma el papel correctamente lorem',
			'marca_id' => '1',
			'personal_lab_id' => '1',
			'cliente_id' => '1',
			'created_at' => date('2019-11-22 00:00:00'),
           	'updated_at' => date('2019-11-22 00:00:00')
		]);
		 DB::table('garantia_guia_ingreso')->insert([
			'id' =>2 ,
			'motivo' => 'TECNICO',
			'fecha' => date('2019-08-01'),
			'orden_servicio' => 'EPHH-23234',
			'estado' => 1,
			'egresado'=> 0,
			'asunto' => 'GARANTIA',
			'nombre_equipo' => 'EPSON L3110',
			'numero_serie' => 'X645008531',
			'codigo_interno' => 'C0004393',
			'fecha_compra' => date('2019-08-01'),
			'descripcion_problema' => 'Falla Reportada: No toma el papel correctamente',
			'revision_diagnostico' => 'Falla Detectada :',
			'estetica' => 'Se observa en buen estado, Ingresa equipo con caja',
			'marca_id' => '2',
			'personal_lab_id' => '2',
			'cliente_id' => '2',
			'created_at' => date('2019-11-22 00:00:00'),
           	'updated_at' => date('2019-11-22 00:00:00')
		]); DB::table('garantia_guia_ingreso')->insert([
			'id' => 3 ,
			'motivo' => 'TECNICO',
			'fecha' => date('2019-08-01'),
			'orden_servicio' => 'EDSDP-0002341',
			'estado' => 1,
			'egresado'=> 0,
			'asunto' => 'GARANTIA',
			'nombre_equipo' => 'EPSON L3110',
			'numero_serie' => 'X645008531',
			'codigo_interno' => 'C0004393',
			'fecha_compra' => date('2019-08-01'),
			'descripcion_problema' => 'Falla Reportada: No toma el papel correctamente',
			'revision_diagnostico' => 'Falla Detectada :',
			'estetica' => 'Se observa en buen estado, Ingresa equipo con caja',
			'marca_id' => '3',
			'personal_lab_id' => '3',
			'cliente_id' => '3',
			'created_at' => date('2019-11-22 00:00:00'),
           	'updated_at' => date('2019-11-22 00:00:00')
		]);
    }
}
