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
			'orden_servicio' => 'EP-000001',
			'estado' => 1,
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
		DB::table('garantia_guia_ingreso')->insert([
			'id' => 2 ,
			'marca' => 'EPSON',
			'motivo' => 'TECNICO',
			'ing_asignado' => 'Fernando Franco Solis',
			'fecha' => date('2019-08-01'),
			'orden_servicio' => 'EP-000002',
			'estado' => 1,
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
    }
}
