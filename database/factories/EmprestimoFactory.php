<?php

use Faker\Generator as Faker;

$factory->define(\App\Emprestimo::class, function (Faker $faker) {
    return [
        'livro_id' => function () {
            return factory('App\Livro')->create();
        },
        'estudante_id' => function () {
            return factory('App\Estudante')->create();
        },
        'devolucao' => Carbon\Carbon::now()->addWeek(),
        'emprestado_em' => Carbon\Carbon::now(),
    ];
});
