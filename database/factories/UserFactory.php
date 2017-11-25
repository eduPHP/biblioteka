<?php

use Faker\Generator as Faker;


$factory->define(App\Usuario::class, function (Faker $faker) {
    static $password;

    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'grupo' => 'usuario',
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\Usuario::class, 'bibliotecario', function () {
    return [
        'grupo' => 'bibliotecario',
    ];
});