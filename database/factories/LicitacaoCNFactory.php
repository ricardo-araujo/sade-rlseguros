<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LicitacaoCN::class, function (Faker $faker) {
    return [
        'id' => $faker->numberBetween(1, 100),
        'portal' => 'cn',
        'nm_uf' => ['SP', 'RJ', 'BA', 'MG', 'AM', 'RS', 'SC', 'BA'][rand(0, 7)],
        'nm_orgao' => $faker->company,
        'nu_uasg' => $faker->numberBetween(10000, 99999),
        'nm_pregao' => $faker->numberBetween(10000, 99999),
        'nm_endereco' => $faker->address,
        'nm_telefone' => $faker->phoneNumber,
        'nm_fax' => $faker->phoneNumber,
        'txt_objeto' => $faker->text(150),
        'nu_modalidade' => $faker->numberBetween(1, 5),
        'nm_modalidade' => 'Pregão Eletrônico',
        'dt_entrega_proposta' => $faker->date('Y-m-d H:i:s'),
        'dt_abertura_proposta' => $faker->date('Y-m-d H:i:s'),
        'has_anexo' => $faker->boolean,
        'nm_anexo_principal' => $faker->file('.', '/tmp', false),
        'dt_registro_anexo' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
