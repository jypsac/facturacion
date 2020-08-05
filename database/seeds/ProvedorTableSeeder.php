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
        DB::table('provedores')->insert([
            'id' => 2 ,
            'ruc' => '06088940157',
            'empresa' => 'NORD FLUID S.p.A',
            'direccion' =>'Via Keplero 24  20019 SETTIMO MILANESE (MI)' ,
            'telefonos' => '+39 02 33979423',
            'email' => "info@nordfluid.it",
            'contacto_provedor' => "Alessandro Guadagni",
            'celular_provedor' => "393402967528",
            'email_provedor' => 'alessandro.guadagni@nordfluid.it',
            'observacion' => "buen Provedor",
            'created_at' => '2020-08-01 11:36:57',
            'updated_at' => "2020-08-01 11:36:57" ,
        ]);
        DB::table('provedores')->insert([
            'id' => 3 ,
            'ruc' => '0003',
            'empresa' => 'Hebei Hengsheng Pumps Co., Ltd',
            'direccion' =>'No.88 Sanjing Road, Botou,Hebei Province, China,062150' ,
            'telefonos' => '0317-8282746',
            'email' => "info@hengyuanpump.com",
            'contacto_provedor' => "Frank",
            'celular_provedor' => '0317-8282746',
            'email_provedor' => 'HSP@hengyuanpump.com',
            'observacion' => "buen Provedor",
            'created_at' => '2020-08-01 11:36:57',
            'updated_at' => "2020-08-01 11:36:57" ,
        ]);
    }
}
