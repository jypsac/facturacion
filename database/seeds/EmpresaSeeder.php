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
			'nombre' => 'HIDROMAXFILTER E.I.R.L.',
			'razon_social' => 'HIDROMAXFILTER E.I.R.L.',
			'ruc' => '20608175963',
			'telefono' => '902502550',
			'movil' => '946026042',
			'correo' => 'ventas@hidromaxfilter.com',
			'pais' => 'Peru',
			'region_provincia' => 'Lima',
			'ciudad' => 'Lima',
			'calle' => 'Calle Felix Tello Rojas Mz H Lote 25Urb Honor y Lealtad de Surco',
			'codigo_postal' => '0000',
			'rubro' => ' VentaS.',
			'moneda_principal' => '1',
			'descripcion' => 'Nos especializamos comercialización de Filtros; hidráulicos de calidad nueva y de las mejores marca líder en el mercado.Por ese motivo ofrecemos y contamos en stock&nbsp; productos&nbsp; de calidad de marcas internacionales como: Rexroth, Parker, Vickers, Hydac, Hilco, Internormen.',
			'pagina_web' => 'https://www.hidromaxfilter.com/',
			'foto' => 'logo.png',
			'background' => 'https://images4.alphacoders.com/113/thumb-1920-1133047.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}