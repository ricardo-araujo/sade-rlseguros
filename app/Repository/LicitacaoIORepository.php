<?php

namespace App\Repository;

use App\Models\LicitacaoIO;

class LicitacaoIORepository extends Repository
{
    protected $model = LicitacaoIO::class;

    /**
     * @param array $attributes
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|LicitacaoIO
     */
    public function create(array $attributes)
    {
        if (filled($attributes['nu_unidade_gestora_executora']) and filled($attributes['link_edital']) and $this->query()
                                                                                                                ->where(['nu_licitacao' => $attributes['id_licitacao']])
                                                                                                                ->doesntExist()) {

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
