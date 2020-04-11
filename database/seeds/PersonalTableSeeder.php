<?php

use App\Personal;
use App\User;
use Illuminate\Database\Seeder;

class PersonalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(Personal::class, 10)->create();*/
        DB::table('personal')->insert([
			'id' => 1 ,
			'nombres' => 'Fernando Franco',
			'apellidos' => 'Solis Quispe',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'fer@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '47587674' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 'Soltero',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'ingeniero',
			'direccion' => 'aV.Rodalds',
			'estado' => '1',
			'estado_trabajador_laboral' => 'Activo',
			'foto' => '1111111-a6.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);
         DB::table('personal')->insert([
			'id' => 2 ,
			'nombres' => 'Neyser Pablo',
			'apellidos' => ' Quispe Villarroel',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'nan@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '70104903' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 'Viudo con hijos',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'Doctor',
			'direccion' => 'aV.Rodalds',
			'estado' => '1',
			'estado_trabajador_laboral' => 'Activo',
			'foto' => '74894537-a1.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

          DB::table('personal')->insert([
			'id' =>3 ,
			'nombres' => 'Christian Gilmar ',
			'apellidos' => 'Flores Gallardo 
  ',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'juñli@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '41882203' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 's',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'obrero',
			'direccion' => 'aV.Rodalds',
			'estado' => '1',
			'estado_trabajador_laboral' => 'Activo',
			'foto' => '74894537-a2.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

           DB::table('personal')->insert([
			'id' => 4 ,
			'nombres' => 'Efrain Apolinario',
			'apellidos' => 'Solis Venancio',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'crs@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '09782642' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 'Casado',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'barrendero',
			'direccion' => 'aV.Rodalds',
			'estado_trabajador_laboral' => 'Activo',
			'estado' => '1',
			'foto' => '74894537-a2.jpg',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

    }
}