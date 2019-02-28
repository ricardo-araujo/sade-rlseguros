<?php

namespace App\Repository;

use App\Models\LicitacaoIO;

class LicitacaoIORepository extends Repository
{
    const MODALIDADE_PREGAO_ELETRONICO = 'PREGÃO ELETRÔNICO';
    const SUBAREA_SEGUROS = 'Seguros';

    protected $model = LicitacaoIO::class;

    /**
     * @param array $attributes
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|LicitacaoIO
     */
    public function create(array $attributes)
    {
        if (
            $this->query()->where(['nu_licitacao' => $attributes['id_licitacao']])->doesntExist() and
            filled($attributes['nu_unidade_gestora_executora'])                                   and
            filled($attributes['link_edital'])                                                    and
            str_is(self::MODALIDADE_PREGAO_ELETRONICO, $attributes['modalidade'])         and
            str_is(self::SUBAREA_SEGUROS, $attributes['subarea'])
        ) {

            return $this->query()->create([
                'portal' => 'io',
                'nu_licitacao' => $attributes['id_licitacao'],
                'nu_orgao' => $attributes['nu_unidade_gestora_executora'],
                'nm_orgao' => $attributes['orgao'],
                'nm_modalidade' => $attributes['modalidade'],
                'txt_objeto' => $attributes['objeto'],
                'dt_publicacao' => $attributes['data_publicacao'],
                'dt_disputa' => $attributes['data_abertura'],
                'nm_pregao' => $attributes['numero'],
                'nm_area' => $attributes['area'],
                'nm_subarea' => $attributes['subarea'],
                'nm_processo' => $attributes['processo'],
                'nm_anexo_principal' => $attributes['nome_edital'],
                'nm_link_anexo' => $attributes['link_edital'],
            ]);
        }

        return false;
    }
}
