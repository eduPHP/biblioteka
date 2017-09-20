<?php

use Faker\Generator as Faker;


$factory->define(App\Usuario::class, function (Faker $faker) {
    static $password;

    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
