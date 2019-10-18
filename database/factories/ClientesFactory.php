<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cliente;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        'nombres' => $faker->firstNameMale,
        'apellidos' => $faker->lastName,
        'direccion' => $faker->address,
        'email' => $faker->email,
        'telefono' => $faker->biasedNumberBetween($min = 1000000, $max = 9999999, $function = 'sqrt'),
        'celular' =>    $faker->biasedNumberBetween($min = 100000000, $max = 999999999, $function = 'sqrt'),
        'empresa' => $faker->firstNameMale." S.A.C",
        'documento_identificacion' => $faker->randomElement($array = array ('DNI','Pasaporte')),
        'numero_documento' => $faker->biasedNumberBetween($min = 10000000, $max = 99999999, $function = 'sqrt'),
    ];
});
