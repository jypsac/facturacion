<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Personal;
use Faker\Generator as Faker;

$factory->define(Personal::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstNameMale,
        'apellidos' => $faker->lastName,
        'fecha_nacimiento' => $faker->date,
        'celular' => $faker->name,
        'telefono' => $faker->name,
        'email' => $faker->email,
        'genero' => $faker->name,
        'documento_identificacion' => $faker->name,
        'numero_documento' => $faker->name,
        'nacionalidad' => $faker->name,
        'estado_civil' => $faker->name,
        'nivel_educativo' => $faker->name,
        'profesion' => $faker->name,
        'direccion' => $faker->address,
        'foto' => 'perfil.svg',
    ];
});
