<?php

use Faker\Generator as Faker;

$factory->define(App\Editora::class, function (Faker $faker) {
    return [
        'nome'=>$faker->sentence(2),
    ];
});
