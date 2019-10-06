<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Personal;
use Faker\Generator as Faker;

$factory->define(Personal::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstNameMale,
        'apellidos' => $faker->lastName,
        'fecha_nacimiento' => $faker->date,
        'celular' =>    $faker->biasedNumberBetween($min = 100000000, $max = 999999999, $function = 'sqrt'),
        'telefono' => $faker->biasedNumberBetween($min = 1000000, $max = 9999999, $function = 'sqrt'),
        'email' => $faker->email,
        'genero' => $faker->randomElement($array = array ('masculino','femenino')),
        'documento_identificacion' => $faker->randomElement($array = array ('DNI','Pasaporte')),
        'numero_documento' => $faker->biasedNumberBetween($min = 10000000, $max = 99999999, $function = 'sqrt'),
        'nacionalidad' => $faker->name,
        'estado_civil' => $faker->randomElement($array = array ('Soltero','casado')),
        'nivel_educativo' => $faker->randomElement($array = array ('Superior','Basico','Universitario','Tecnico')),
        'profesion' => $faker->name,
        'direccion' => $faker->address,
        'foto' => 'perfil.svg',
    ];
});
