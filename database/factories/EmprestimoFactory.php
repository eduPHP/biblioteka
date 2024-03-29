<?php

use Faker\Generator as Faker;

$factory->define(\App\Emprestimo::class, function (Faker $faker) {
    $now = Carbon\Carbon::now()->subDay(rand(1,5));

    return [
        'livro_id' => function () {
            return factory('App\Livro')->create();
        },
        'estudante_id' => function () {
            return factory('App\Estudante')->create();
        },
        'devolucao' => $now->addWeek(),
        'emprestado_em' => $now,
    ];
});
