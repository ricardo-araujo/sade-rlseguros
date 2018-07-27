<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ReservaBB::class, function (Faker $faker) {
    return [
        'id' => $faker->numberBetween(1, 100),
        'id_licitacao' => factory(App\Models\LicitacaoBB::class)->create(),
        'nm_reserva' => $faker->numberBetween(100000, 999999),
        'nm_viewstate' => $faker->text(50),
        'nm_eventvalidation' => $faker->text(100),
        'was_uploaded' => $faker->boolean,
        'dt_inicio_upload' => $faker->date('Y-m-d H:i:s'),
        'dt_fim_upload' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
