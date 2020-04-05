<?php

use Illuminate\Database\Seeder;

class PersonalVentasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('personal_ventas')->insert([
			'id' => 1 ,
			'id_personal' => '1',
			'cod_vendedor' => 'VE001',
			'tipo_comision' => 'Porcentaje de Venta' ,
			'comision' => '10',
			'estado' => '0',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
		]);

    }
}
