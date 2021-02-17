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
    		'nombres' => 'Administrador',
    		'apellidos' => 'Administrador',
    		'fecha_nacimiento' => '2000-01-01' ,
    		'celular' => '123456789',
    		'telefono' => '1234567',
    		'email' => 'desarrollo@jypsac.com' ,
    		'genero' => 'masculino',
    		'documento_identificacion' => 'DNI',
    		'numero_documento' => '00000000' ,
    		'nacionalidad' => 'Peruano',
    		'estado_civil' => 'Soltero',
    		'nivel_educativo' => 'Bachiller',
    		'profesion' => 'Ingeniero Industrial',
    		'direccion' => '00',
    		'estado' => '1',
            'estado_trabajador_laboral' => 'Activo',
    		'usuario_registrado' => '1',
    		'foto' => '47587674-descarga.jpg',
    		'created_at' => date('2020-07-01 00:00:00'),
    		'updated_at' => date('2020-07-01 00:00:00'),
    	]);
        DB::table('personal')->insert([
            'id' => 2 ,
            'nombres' => 'Juloii',
            'apellidos' => 'Vicu',
            'fecha_nacimiento' => '2000-01-01' ,
            'celular' => '123456789',
            'telefono' => '1234567',
            'email' => 'desarrollo@jypwsac.com' ,
            'genero' => 'masculino',
            'documento_identificacion' => 'DNI',
            'numero_documento' => '00000000' ,
            'nacionalidad' => 'Peruano',
            'estado_civil' => 'Soltero',
            'nivel_educativo' => 'Bachiller',
            'profesion' => 'Ingeniero Industrial',
            'direccion' => '00',
            'estado' => '1',
            'estado_trabajador_laboral' => 'Activo',
            'usuario_registrado' => '1',
            'foto' => '47587674-descarga.jpg',
            'created_at' => date('2020-07-01 00:00:00'),
            'updated_at' => date('2020-07-01 00:00:00'),
        ]);
    //     DB::table('personal')->insert([
    //         'id' => 2 ,
    //         'nombres' => 'Jean Carlo ',
    //         'apellidos' => 'Picon Molina',
    //         'fecha_nacimiento' => '1985-03-22' ,
    //         'celular' => '998342017',
    //         'telefono' => '2477161',
    //         'email' => 'ventas2@hidromaxsac.com' ,
    //         'genero' => 'masculino',
    //         'documento_identificacion' => 'DNI',
    //         'numero_documento' => '42905812' ,
    //         'nacionalidad' => 'Peruano',
    //         'estado_civil' => 'Soltero',
    //         'nivel_educativo' => 'Bachiller',
    //         'profesion' => 'Ingeniero Industrial',
    //         'direccion' => '00',
    //         'estado' => '1',
    //         'estado_trabajador_laboral' => 'Activo',
    //         'usuario_registrado' => '1',
    //         'foto' => '74894537-a4.jpg',
    //         'created_at' => date('2020-07-01 00:00:00'),
    //         'updated_at' => date('2020-07-01 00:00:00'),
    //     ]);
    //     DB::table('personal')->insert([
    //         'id' => 3 ,
    //         'nombres' => 'Milagros  Rocio',
    //         'apellidos' => 'Picon Molina',
    //         'fecha_nacimiento' => '1974-05-6' ,
    //         'celular' => '941378475',
    //         'telefono' => '2477162',
    //         'email' => 'ventas3@hidromaxsac.com' ,
    //         'genero' => 'femenimo',
    //         'documento_identificacion' => 'DNI',
    //         'numero_documento' => '10710604' ,
    //         'nacionalidad' => 'Peruano',
    //         'estado_civil' => 'Casada',
    //         'nivel_educativo' => 'Superior',
    //         'profesion' => 'Administracion',
    //         'direccion' => '00',
    //         'estado' => '1',
    //         'estado_trabajador_laboral' => 'Activo',
    //         'usuario_registrado' => '1',
    //         'foto' => '74894537-a6.jpg',
    //         'created_at' => date('2020-07-01 00:00:00'),
    //         'updated_at' => date('2020-07-01 00:00:00'),
    //     ]);
    //     DB::table('personal')->insert([
    //         'id' => 4,
    //         'nombres' => 'Fulano  Fulano',
    //         'apellidos' => 'Picon Molina',
    //         'fecha_nacimiento' => '1974-05-6' ,
    //         'celular' => '941378475',
    //         'telefono' => '2477162',
    //         'email' => 'ventas4@hidromaxsac.com' ,
    //         'genero' => 'femenimo',
    //         'documento_identificacion' => 'DNI',
    //         'numero_documento' => '10710604' ,
    //         'nacionalidad' => 'Peruano',
    //         'estado_civil' => 'Casada',
    //         'nivel_educativo' => 'Superior',
    //         'profesion' => 'Administracion',
    //         'direccion' => '00',
    //         'estado' => '1',
    //         'estado_trabajador_laboral' => 'Activo',
    //         'usuario_registrado' => '0',
    //         'foto' => '74894537-a1.jpg',
    //         'created_at' => date('2020-07-01 00:00:00'),
    //         'updated_at' => date('2020-07-01 00:00:00'),
    //     ]);
    }
}