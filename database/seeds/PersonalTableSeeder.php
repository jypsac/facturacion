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
			'nombres' => 'fernando',
			'apellidos' => 'miranda',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'fer@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '23432433' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 's',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'ingeniero',
			'direccion' => 'aV.Rodalds',
			'foto' => '',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

         DB::table('personal')->insert([
			'id' => 2 ,
			'nombres' => 'Nando',
			'apellidos' => 'FEfe',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'nan@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '23432433' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 's',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'Doctor',
			'direccion' => 'aV.Rodalds',
			'foto' => '',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

          DB::table('personal')->insert([
			'id' =>3 ,
			'nombres' => 'Juliio',
			'apellidos' => 'Flores',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'juñli@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '23432433' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 's',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'obrero',
			'direccion' => 'aV.Rodalds',
			'foto' => '',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

           DB::table('personal')->insert([
			'id' => 4 ,
			'nombres' => 'cristo',
			'apellidos' => 'fer',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'crs@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '23432433' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 's',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'barrendero',
			'direccion' => 'aV.Rodalds',
			'foto' => '',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);

           DB::table('personal')->insert([
			'id' => 5 ,
			'nombres' => 'nono',
			'apellidos' => 'del amor',
			'fecha_nacimiento' => '2019-08-01' ,
			'celular' => '324234234',
			'telefono' => '5235432',
			'email' => 'nono@gma.com' ,
			'genero' => 'masculino',
			'documento_identificacion' => 'DNI',
			'numero_documento' => '23432433' ,
			'nacionalidad' => 'Peru',
			'estado_civil' => 's',
			'nivel_educativo' => 'Secundaria',
			'profesion' => 'gerente',
			'direccion' => 'aV.Rodalds',
			'foto' => '',
			'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
			        ]);
    }
}