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
			'marca' => 'EPSON',
			'motivo' => 'TECNICO',
			'ing_asignado' => 'Fernando Franco Solis',
			'fecha' => date('2019-08-01'),
			'orden_servicio' => 'EP-000000001',
			'asunto' => 'GARANTIA',
			'nombre_cliente' => 'Empresa de Transportes Pasajeros y Carga Cavasa S.A.C',
			'direccion' => 'JR. RAYMONDI NRO 125 . LA VICTORIA',
			'telefono' => '997841122',
			'correo' => 'cavasspaseo@gmail.com',
			'contacto' => 'Wilder Felipe Jaimes Abauca',
			'nombre_equipo' => 'EPSON L3110',
			'numero_serie' => 'X645008531',
			'codigo_interno' => 'C0004393',
			'fecha_compra' => date('2019-08-01'),
			'descripcion_problema' => 'Falla Reportada: No toma el papel correctamente',
			'revision_diagnostico' => 'Falla Detectada :',
			'estetica' => 'Se observa en buen estado, Ingresa equipo con caja',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
		// DB::table('garantia_guia_egreso')->insert([
		// 	'id' => 2 ,
		// 	'marca' => '001',
		// 	'motivo' => 'TABLETS',
		// 	'ing_asignado' => '001',
		// 	'fecha' => 'TABLETS',
		// 	'orden_servicio' => '001',
		// 	'asunto' => 'TABLETS',
		// 	'nombre_cliente' => '001',
		// 	'direccion' => 'TABLETS',
		// 	'telefono' => '001',
		// 	'contacto' => 'TABLETS',
		// 	'nombre_equipo' => '001',
		// 	'numero_serie' => 'TABLETS',
		// 	'codigo_interno' => '001',
		// 	'fecha_compra' => 'TABLETS',
		// 	'descripcion_problema' => 'Alimentacion multiple,toma bastantes hojas de papel /Factura a nombre de : Empresa de Transportes, Pasajeros y Carga Cavasa SAC /Fecha de Compra: 27/03/2019',
		// 	'revision_diagnostico' => 'TABLETS',
		// 	'estetica' => 'TABLETS',
		// 	'created_at' => date('2019-08-01 00:00:00'),
  		//  'updated_at' => date('2019-08-01 00:00:00')
		// ]);
    }
}
