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
			'nombre' => 'HIDROMAX S.A.C.e',
			'razon_social' => 'HIDROMAX S.A.C.',
			'ruc' => '20548110719',
			'telefono' => '(51-1) 247 7161',
			'movil' => '946 026 042',
			'correo' => 'ventas@hidromaxsac.com',
			'pais' => 'Peru',
			'region_provincia' => 'Lima',
			'ciudad' => 'Lima',
			'calle' => 'Calle Felix Tello Rojas Mz H Lote 25 Urb Honor y Lealtad de Surco',
			'codigo_postal' => '50304',
			'rubro' => ' Venta Partes, Piezas, Accesorios.',
			'moneda_principal' => 'Soles',
			'descripcion' => 'Nos especializamos ela comercialización de bombas y motores óleo hidráulicos de calidad nueva y de las mejores marca líder en el mercado. Por ese motivo ofrecemos y contamos en stock productos de calidad de marcas internacionales como: Rexroth, Parker, Vickers, Eaton, Denison Hydraulics',
			'pagina_web' => 'https://hidromax-sac.negocio.site/',
			'foto' => 'logo.png',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}