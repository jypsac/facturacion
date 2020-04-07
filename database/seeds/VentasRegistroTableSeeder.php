<?php

use Illuminate\Database\Seeder;

class VentasRegistroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('ventas_registro')->insert([
			'id' => 1 ,
			'numero_cotizacion' => 'Cos22',
			'tipo' => 'FA',
			'estado_aprobado' => '0',
			'pago_efectuado' => '0',
			'observacion' => 'observadno como ahve xDm',
			'id_vendedor' => '1',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
		]);
         DB::table('ventas_registro')->insert([
			'id' => 2 ,
			'numero_cotizacion' => 'CO23',
			'tipo' => 'FA',
			'estado_aprobado' => '0',
			'pago_efectuado' => '0',
			'observacion' => 'observadno como ahve ric arho  klñasdnm j to nquie jasefd jsdscds',
			'id_vendedor' => '1',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
		]);
         DB::table('ventas_registro')->insert([
			'id' => 3 ,
			'numero_cotizacion' => 'Co-123',
			'tipo' => 'FA',
			'estado_aprobado' => '1',
			'pago_efectuado' => '1',
			'observacion' => 'observadno como ahve xDm',
			'id_vendedor' => '1',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
		]);
    }

}
