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
			'nombre' => 'Empresa',
			'razon_social' => 'Empresa',
			'ruc' => '00000000000',
			'telefono' => '000000000',
			'movil' => '000000000',
			'correo' => 'sincorreo@gmail.com',
			'pais' => 'Peru',
			'region_provincia' => 'Lima',
			'ciudad' => 'Lima',
			'calle' => 'Direccion de la Empresa',
			'codigo_postal' => '150101',
			'rubro' => ' VentaS.',
			'moneda_principal' => '1',
			'descripcion' => 'Descripcion',
			'pagina_web' => 'https://www.sitioweb.com/',
			'foto' => 'logo.png',
			'background' => 'https://images4.alphacoders.com/113/thumb-1920-1133047.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}