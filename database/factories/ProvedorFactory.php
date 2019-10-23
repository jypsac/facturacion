<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Provedor;
use Faker\Generator as Faker;

$factory->define(Provedor::class, function (Faker $faker) {
    return [
        'ruc' => $faker->biasedNumberBetween($min = 10000000, $max = 99999999, $function = 'sqrt'),
        'empresa' => $faker->firstNameMale." S.A.C",
        'direccion' => $faker->address,
        'telefonos' => $faker->biasedNumberBetween($min = 1000000, $max = 9999999, $function = 'sqrt'),
        'email' => $faker->email,
        'contacto_provedor' => $faker->firstNameMale,
        'celular_provedor' =>    $faker->biasedNumberBetween($min = 100000000, $max = 999999999, $function = 'sqrt'),
        'email_provedor' => $faker->email,
        'observacion'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis eros quis augue scelerisque, sed interdum elit vestibulum. Donec lorem nisl, ullamcorper in commodo non, condimentum id velit. Cras a varius nibh. Etiam consectetur accumsan commodo. Proin leo erat, tincidunt et iaculis nec, elementum a est. Nulla pretium elementum suscipit. Fusce sed varius velit',
    ];
});
