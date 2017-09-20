<?php

use Faker\Generator as Faker;

$factory->define(\App\Estudante::class, function (Faker $faker) {
    return [
        'nome' => $faker->name(),
        'matricula' => $faker->numberBetween(300, 3000),
    ];
});
