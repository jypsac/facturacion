<?php

use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresa')->insert([
			'id' => 1 ,
			'nombre' => 'Empresa S.A.C.',
			'razon_social' => 'Empresa S.A.C.',
			'ruc' => '013658742',
			'telefono' => '(511) 123 456',
			'movil' => '946 026 042',
			'correo' => 'empresa@empresa.com',
			'pais' => 'Peru',
			'region_provincia' => 'Lima',
			'ciudad' => 'Lima',
			'calle' => 'Direccion',
			'codigo_postal' => '0000',
			'rubro' => ' VentaS.',
			'moneda_principal' => '1',
			'descripcion' => 'Descripcion',
			'pagina_web' => 'https://jypsac.com/',
			'foto' => 'logo.png',
			'background' => 'https://images2.alphacoders.com/361/thumb-1920-36170.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}