<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LicitacaoIO::class, function (Faker $faker) {
    return [
        'id' => $faker->numberBetween(1, 100),
        'id_orgao' => $faker->numberBetween(1, 5),
        'portal' => 'io',
        'nu_licitacao' =>  $faker->numberBetween(1000000, 9999999),
        'nu_orgao' =>  $faker->numberBetween(100000, 999999),
        'nm_orgao' =>  $faker->name,
        'nm_modalidade' => 'PREGÃO ELETRÔNICO',
        'txt_objeto' => $faker->text(150),
        'dt_publicacao' => $faker->date('Y-m-d H:i:s'),
        'dt_disputa' => $faker->date('Y-m-d H:i:s'),
        'nm_pregao' => $faker->numerify('###/##'),
        'nm_area' => 'Serviços Comuns',
        'nm_subarea' => 'Seguros',
        'nm_processo' => $faker->numerify('###/##'),
        'nm_anexo_principal' => $faker->file('.', '/tmp', false),
        'nm_link_anexo' => $faker->url,
        'dt_registro_anexo' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
