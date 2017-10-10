<?php

use Faker\Generator as Faker;

$factory->define(App\Secao::class, function (Faker $faker) {
    return [
        'descricao'=>$faker->sentence(3),
        'localizacao'=>$faker->sentence(2)
    ];
});
