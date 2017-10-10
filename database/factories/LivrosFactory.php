<?php

use Faker\Generator as Faker;

$factory->define(App\Livro::class, function (Faker $faker) {
    return [
        'isbn' => $faker->unique()->numberBetween(12345, 54321),
        'titulo' => $faker->sentence(3),
        'descricao' => $faker->sentence,
        'quantidade' => rand(1, 5),
        'ano' => $faker->year,
        'edicao' => rand(1, 20),
        'secao_id' => function () {
            return factory('App\Secao')->create()->id;
        },
        'editora_id' => function () {
            return factory('App\Editora')->create()->id;
        },
    ];
});
