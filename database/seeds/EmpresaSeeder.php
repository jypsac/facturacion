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
			'nombre' => 'JYP PERIFERICOS',
			'razon_social' => 'J y P Perifericos SAC',
			'ruc' => 75237849,
			'telefono' => 983272362,
			'movil' => 789456123,
			'correo' => 'julio@jypsac.com',
			'pais' => 'Peru',
			'region_provincia' => 'Lima',
			'ciudad' => 'Lince',
			'calle' => 'Arenales',
			'codigo_postal' => '12584',
			'rubro' => 'Computación y Informática',
			'moneda_principal' => 'Soles',
			'descripcion' => 'Empresa de mantenimiento informático, venta de computadoras, hardware, software Erp, elaboración de páginas web, redes y comunicaciones, utilizando la tecnología actual para servirlos mejor. Capacitación, asesoría para las pequeñas, medianas y empresas corporativas, en sus diferentes áreas implementando así su potencial de crecimiento empresarial.',
			'foto' => 'logo.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}
