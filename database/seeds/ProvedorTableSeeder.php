<?php
use App\Provedor;
use Illuminate\Database\Seeder;

class ProvedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('provedores')->insert([
    		'id' => 1 ,
    		'ruc' => '000',
    		'empresa' => 'Saar HK Electronic Limited',
    		'direccion' =>'Rm 1506,28# Moyu Rd,Shanghai,China,201805' ,
    		'telefonos' => '+86-21-5956 1370*803',
    		'email' => "sales@saar-hk.com",
    		'contacto_provedor' => "Jason",
    		'celular_provedor' => "8613918187448",
    		'email_provedor' => 'sales@saar-hydraulic.com',
    		'observacion' => "buen Provedor",
    		'created_at' => '2020-08-01 11:36:57',
    		'updated_at' => "2020-08-01 11:36:57" ,
    	]);
    }
}
