<?php

use Faker\Generator as Faker;

$factory->define(App\Livro::class, function (Faker $faker) {
    return [
        'titulo' => $faker->sentence(3),
        'isbn' => $faker->numberBetween(12345, 54321),
    ];
});
