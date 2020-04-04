<?php

use Illuminate\Database\Seeder;

class PersonalVentasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('personal_ventas')->insert([
			'id' => 1 ,
			'cod_vendedor' => 'COM001',
			'nombres' => 'Nono Leono',
			'apellidos' => 'Solis Quispe',
			'fecha_nacimiento' => '2019-08-01' ,
			'documento_identificacion' => 'DNI',
			'numero_documento' => '47587674' ,
			'nacionalidad' => 'Peru',
			'direccion' => 'aV.Rodalds',
			'celular' => '324234234',
			'correo' => 'Nono@gma.com' ,
			'comision' => '10',
			'estado' => '0',
			'tipo_trabajador' => 'externo',
			'foto' => '1111111-a6.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
		]);
		DB::table('personal_ventas')->insert([
			'id' => 2 ,
			'cod_vendedor' => 'COM002',
			'nombres' => 'Cristofer css',
			'apellidos' => 'Solis Quispe',
			'fecha_nacimiento' => '2019-08-01' ,
			'documento_identificacion' => 'DNI',
			'numero_documento' => '12312' ,
			'nacionalidad' => 'Peru',
			'direccion' => 'aV.Rodalds',
			'celular' => '324234234',
			'correo' => 'Cristofer@gma.com' ,
			'comision' => '30',
			'estado' => '0',
			'tipo_trabajador' => 'interno',
			'foto' => '1111111-a6.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
		]);
		DB::table('personal_ventas')->insert([
			'id' => 3 ,
			'cod_vendedor' => 'COM003',
			'nombres' => 'Daniel Choro',
			'apellidos' => 'Solis Quispe',
			'fecha_nacimiento' => '2019-08-01' ,
			'documento_identificacion' => 'DNI',
			'numero_documento' => '7879778987' ,
			'nacionalidad' => 'Peru',
			'direccion' => 'aV.Rodalds',
			'celular' => '324234234',
			'correo' => 'Daniel@gma.com' ,
			'comision' => '15',
			'estado' => '0',
			'tipo_trabajador' => 'externo',
			'foto' => '1111111-a6.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
		]);

		DB::table('personal_ventas')->insert([
			'id' => 4 ,
			'cod_vendedor' => 'COM004',
			'nombres' => 'Ledy novedades',
			'apellidos' => 'Solis Quispe',
			'fecha_nacimiento' => '2019-08-01' ,
			'documento_identificacion' => 'DNI',
			'numero_documento' => '78456546' ,
			'nacionalidad' => 'Peru',
			'direccion' => 'aV.Rodalds',
			'celular' => '324234234',
			'correo' => 'Ledy@gma.com' ,
			'comision' => '20',
			'estado' => '0',
			'tipo_trabajador' => 'interno',
			'foto' => '1111111-a6.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
		]);

    }
}
