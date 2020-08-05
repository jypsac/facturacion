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
    	DB::table('personal')->insert([
    		'id' => 1 ,
    		'nombres' => 'Mauro Enrique',
    		'apellidos' => 'Picon Molina',
    		'fecha_nacimiento' => '1976-06-11' ,
    		'celular' => '946026042',
    		'telefono' => '2477161',
    		'email' => 'ventas@hidromaxsac.com' ,
    		'genero' => 'masculino',
    		'documento_identificacion' => 'DNI',
    		'numero_documento' => '10548055' ,
    		'nacionalidad' => 'Peruano',
    		'estado_civil' => 'Soltero',
    		'nivel_educativo' => 'Bachiller',
    		'profesion' => 'Ingeniero Industrial',
    		'direccion' => '00',
    		'estado' => '1',
    		'estado_trabajador_laboral' => 'Activo',
    		'foto' => '47587674-descarga.jpg',
    		'created_at' => date('2020-07-01 00:00:00'),
    		'updated_at' => date('2020-07-01 00:00:00'),
    	]);
        DB::table('personal')->insert([
            'id' => 2 ,
            'nombres' => 'Jean Carlo ',
            'apellidos' => 'Picon Molina',
            'fecha_nacimiento' => '1985-03-22' ,
            'celular' => '998342017',
            'telefono' => '2477161',
            'email' => 'ventas2@hidromaxsac.com' ,
            'genero' => 'masculino',
            'documento_identificacion' => 'DNI',
            'numero_documento' => '42905812' ,
            'nacionalidad' => 'Peruano',
            'estado_civil' => 'Soltero',
            'nivel_educativo' => 'Bachiller',
            'profesion' => 'Ingeniero Industrial',
            'direccion' => '00',
            'estado' => '1',
            'estado_trabajador_laboral' => 'Activo',
            'foto' => '47587674-descarga.jpg',
            'created_at' => date('2020-07-01 00:00:00'),
            'updated_at' => date('2020-07-01 00:00:00'),
        ]);
        DB::table('personal')->insert([
            'id' => 3 ,
            'nombres' => 'Milagros  Rocio',
            'apellidos' => 'Picon Molina',
            'fecha_nacimiento' => '1974-05-6' ,
            'celular' => '941378475',
            'telefono' => '2477162',
            'email' => 'ventas3@hidromaxsac.com' ,
            'genero' => 'femenimo',
            'documento_identificacion' => 'DNI',
            'numero_documento' => '10710604' ,
            'nacionalidad' => 'Peruano',
            'estado_civil' => 'Casada',
            'nivel_educativo' => 'Superior',
            'profesion' => 'Administracion',
            'direccion' => '00',
            'estado' => '1',
            'estado_trabajador_laboral' => 'Activo',
            'foto' => '47587674-descarga.jpg',
            'created_at' => date('2020-07-01 00:00:00'),
            'updated_at' => date('2020-07-01 00:00:00'),
        ]);
    }
}