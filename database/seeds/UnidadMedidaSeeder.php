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
			'simbolo' => 'DOC',
			'medida' => 'Docena',
			'unidad' => '12',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}
