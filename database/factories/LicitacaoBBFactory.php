<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LicitacaoBB::class, function (Faker $faker) {
    return [
        'id' => $faker->numberBetween(1, 100),
        'portal' => 'bb',
        'nu_licitacao' => $faker->numberBetween(100000, 999999),
        'txt_objeto' => $faker->realText(150),
        'nu_cliente' => $faker->numberBetween(10000, 99999),
        'nm_cliente' => $faker->company,
        'nu_pregoeiro' => $faker->numberBetween(100, 999),
        'nm_pregoeiro' => $faker->name,
        'nm_pregao' => $faker->numerify('###/##'),
        'nm_processo' => $faker->numerify('#.###/####'),
        'nu_modalidade' => $faker->numberBetween(1, 5),
        'nm_tipo' => 'Menor preço',
        'nm_participacao_fornecedor' => $faker->userName,
        'nm_prazo_impugnacao' => $faker->date('Y-m-d H:i:s'),
        'nu_situacao' => $faker->numberBetween(1, 5),
        'nm_situacao' => $faker->word,
        'nu_idioma' => $faker->numberBetween(0, 10),
        'nm_idioma' => $faker->languageCode,
        'nu_abrangencia' => $faker->numberBetween(1, 50),
        'nm_abrangencia' => $faker->country,
        'nm_moeda' => $faker->currencyCode,
        'nm_moeda_proposta' => $faker->currencyCode,
        'nm_fonte' => $faker->colorName,
        'nm_uf' => ['SP', 'RJ', 'BA', 'MG', 'AM', 'RS', 'SC', 'BA'][rand(0, 7)],
        'dt_publicacao' => $faker->date('Y-m-d H:i:s'),
        'dt_ini_acolhimento_proposta' => $faker->date('Y-m-d H:i:s'),
        'dt_fim_acolhimento_proposta' => $faker->date('Y-m-d H:i:s'),
        'dt_abertura_proposta' => $faker->date('Y-m-d H:i:s'),
        'dt_disputa' => $faker->date('Y-m-d H:i:s'),
        'dt_criado' => $faker->date('Y-m-d H:i:s'),
        'st_equalizada' => $faker->boolean,
        'nm_link_anexo' => $faker->url,
        'nm_anexo_principal' => $faker->file('.', '/tmp', false),
        'dt_registro_anexo' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
