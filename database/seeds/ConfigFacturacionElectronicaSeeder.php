<?php

use Illuminate\Database\Seeder;

class ConfigFacturacionElectronicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_fe')->insert([
			'id' => 1 ,
			'ruc' => '20000000001',
			'usuario' => 'MODDATOS',
			'password' => 'moddatos',
			'certificado' => 'certificado/certificate.pem',
			'modo' => 'FE_BETA',

		]);
    }
}
