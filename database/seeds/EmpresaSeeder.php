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
			'nombre' => 's&r solution service',
			'razon_social' => 'S & R SOLUTION SERVICE S.A.C.',
			'ruc' => '20524840902',
			'telefono' => '4235390',
			'movil' => '981145518',
			'correo' => 'esolis@srsac.com',
			'pais' => 'Peru',
			'region_provincia' => 'Lima',
			'ciudad' => 'Lima',
			'calle' => 'Av. Bolivia Nro. 180 Of-306 C.C Wilson Plaza',
			'codigo_postal' => '15001',
			'rubro' => ' soluciones de problemas de operatividad informática',
			'moneda_principal' => 'Soles',
			'descripcion' => 'S&R Solution Service S.A.C., es una empresa orientada a las soluciones de problemas de operatividad informática, principalmente de temas ligados a Hardware de impresión de distintas marca, siendo una de nuestras principales la marca EPSON..

			Gracias a una organización flexible, al desarrollo de nuevas ventajas competitivas y a la permanente optimización de nuestros servicios, buscaremos adecuarnos a las necesidades y requerimientos de colaboración de cada cliente, desde el inicio de sus necesidades.',
			'foto' => 'logo.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}
