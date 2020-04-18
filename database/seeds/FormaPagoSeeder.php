<?php

use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('forma_pago')->insert([
            'id' => 1 ,
            'nombre' => 'Contado ',
            'dias'=>'0',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        // DB::table('forma_pago')->insert([
        //     'id' => 2 ,
        //     'nombre' => 'Adelantado',
        //     'created_at' => date('2019-08-01 00:00:00'),
        //    	'updated_at' => date('2019-08-01 00:00:00')
        // ]);
        
        DB::table('forma_pago')->insert([
            'id' => 2 ,
            'nombre' => 'Cheque dif 7 dias',
            'dias'=>'7',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('forma_pago')->insert([
            'id' => 3 ,
            'nombre' => 'Cheque dif 15 dias',
            'dias'=>'15',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('forma_pago')->insert([
            'id' => 4 ,
            'nombre' => '50 % adelanto,saldo contra entrega',
            'dias'=>'0',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('forma_pago')->insert([
            'id' => 5 ,
            'nombre' => 'Contado / contra entrega',
            'dias'=>'0',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('forma_pago')->insert([
            'id' => 6 ,
            'nombre' => 'Factura 7 dias',
            'dias'=>'7',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('forma_pago')->insert([
            'id' => 7 ,
            'nombre' => 'Factura 15 dias',
            'dias'=>'15',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('forma_pago')->insert([
            'id' => 8 ,
            'nombre' => 'Factura 20 dias',
            'dias'=>'20',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);
        
        DB::table('forma_pago')->insert([
            'id' => 9 ,
            'nombre' => 'Factura 30 dias',
            'dias'=>'30',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
        DB::table('forma_pago')->insert([
            'id' => 10 ,
            'nombre' => 'Contado / Cheque al Día',
            'dias'=>'0',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
