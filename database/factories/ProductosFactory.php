<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Producto;
use Faker\Generator as Faker;

$factory->define(\App\Producto::class, function (Faker $faker) {
    return [
        'codigo_producto' => "00002",
        'codigo_original' =>$faker->numberBetween($min = 1, $max = 900000000),
        'nombre' => "Producto".$faker->unique()->numberBetween(1,1000),
        'utilidad' => $faker->randomDigit,
        'descuento1' => $faker->randomDigit,
        'descuento2' => $faker->randomDigit,
        'descuento_maximo' => $faker->randomDigit,
        'descripcion' => "descripcion",
        'origen' => "origen",
        'garantia' => "garantia",
        'peso' => "100",
        'stock_minimo' => $faker->randomDigit,
        'stock_maximo' => $faker->unique()->numberBetween(100, 1000),
        'foto' =>'defecto.png',
        'estado_anular' => 1,
        'categoria_id' => 2,
        'familia_id' => 1,
        'marca_id' => 1,
        'unidad_medida_id' =>7,
        'estado_id' => 1,

    ];
});
