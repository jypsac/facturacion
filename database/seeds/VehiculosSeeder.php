<?php

use Illuminate\Database\Seeder;

class VehiculostableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehiculos')->insert([
			'id' => 0 ,
			'placa' => 'EX4M1',
            'marca' => 'Vehiculo  ',
            'modelo' => 'Modelo',
            'año' => '2000',
			'certificado_inscripcion' => '00000000000',
            'estado_activo' => '0',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        // DB::table('vehiculos')->insert([
        //     'id' => 2,
        //     'placa' => 'A78-405',
        //     'marca' => 'Kia',
        //     'modelo' => 'acces',
        //     'año' => '2002',
        //     'estado_activo' => '0',
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);
        // DB::table('vehiculos')->insert([
        //     'id' => 3 ,
        //     'placa' => 'A2E-456',
        //     'marca' => 'chebrolet',
        //     'modelo' => 'sses',
        //     'año' => '2020',
        //     'año' => '2020',
        //     'estado_activo' => '0',
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00')
        // ]);


    }
}
