<?php

namespace App\Repository;

use App\Models\LicitacaoBB;

class LicitacaoBBRepository extends Repository
{
    private const MODALIDADE_CORRETA = 3;

    protected $model = LicitacaoBB::class;

    public function create(array $attributes)
    {
        if ($attributes['id_modalidade'] == LicitacaoBBRepository::MODALIDADE_CORRETA && $this->query()
                                                                                              ->where(['nu_licitacao' => $attributes['nu_licitacao']])
                                                                                              ->doesntExist()) {

            return $this->query()->create([
                'nu_licitacao' => $attributes['nu_licitacao'],
                'txt_objeto' => $attributes['txt_resumo'],
                'nu_cliente' => $attributes['id_cliente'],
                'nm_cliente' => $attributes['nm_cliente'],
                'nu_pregoeiro' => $attributes['id_pregoeiro'],
                'nm_pregoeiro' => $attributes['nm_pregoeiro'],
                'nu_coordenador' => $attributes['id_coordenador'],
                'nm_coordenador' => $attributes['nm_coordenador'],
                'nu_presidente_comissao' => $attributes['id_presidente_comissao'],
                'nm_edital' => $attributes['nm_edital'],
                'nm_processo' => $attributes['nm_processo'],
                'nu_modalidade' => $attributes['id_modalidade'],
                'nm_tipo' => $attributes['nm_tipo'],
                'nm_participacao_fornecedor' => $attributes['nm_participacao_fornecedor'],
                'nm_prazo_impugnacao' => $attributes['nm_prazo_impugnacao'],
                'nu_situacao' => $attributes['id_situacao'],
                'nm_situacao' => $attributes['nm_situacao'],
                'nu_idioma' => $attributes['id_idioma'],
                'nm_idioma' => $attributes['nm_idioma'],
                'nu_abrangencia' => $attributes['id_abrangencia'],
                'nm_abrangencia' => $attributes['nm_abrangencia'],
                'nm_moeda' => $attributes['nm_moeda'],
                'nm_moeda_proposta' => $attributes['nm_moeda_proposta'],
                'nm_fonte' => $attributes['fonte'],
                'st_equalizada' => $attributes['st_equalizada'],
                'nm_uf' => $attributes['uf'] ?? null,
                'dt_publicacao' => $attributes['dt_publicacao'],
                'dt_ini_acolhimento_proposta' => $attributes['dt_ini_acolhimento_prop'],
                'dt_fim_acolhimento_proposta' => $attributes['dt_fim_acolhimento_prop'],
                'dt_abertura_proposta' => $attributes['dt_abertura_prop'],
                'dt_disputa' => $attributes['dt_disputa'],
                'dt_criado' => $attributes['dt_criado'],
                'nm_link_anexo' => $attributes['arquivoList']
            ]);
        }
    }
}