<?php

use Illuminate\Database\Seeder;

class Personal_laboralTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('personal_datos_laborales')->insert([
			'id' => 1 ,
			'personal_id' => 1,
			'fecha_vinculacion' => '2019-08-01',
			'fecha_retiro' => '2019-08-01' ,
			'forma_pago' => 'Semanal',
			'salario' => 100,
			'categoria_ocupacional' => 'Empleado' ,
			'estado_trabajador' => 'Activo',
			'sede' => 'comas',
			'turno' => 'Tarde' ,
			'departamento_area' => 'Comercial',
			'cargo' => 'Contador',
			'tipo_trabajador' => 'Interno',
			'tipo_contrato' => 'Practicante',
			'regimen_pensionario' => 'Nacional',
			'afiliacion_salud' =>'ONP',
            'banco_renumeracion' => 'Continental',
            'numero_cuenta' => 3243535,
            'notas' => '20',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

    }
}