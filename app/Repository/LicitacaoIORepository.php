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
        if (mb_strtolower($attributes['nmSubarea']) == 'seguros' and $this->query()
                                                                           ->where(['nu_licitacao' => $attributes['idLicitacao']])
                                                                           ->doesntExist()) {

            return $this->query()->create([
                'portal' => 'io',
                'nu_licitacao' => $attributes['idLicitacao'],
                'nu_orgao' => $attributes['idUnidadeGestoraExecucao'],
                'nm_orgao' => $attributes['nmOrgao'],
                'nm_modalidade' => $attributes['nmModalidade'],
                'txt_objeto' => $attributes['txtObjeto'],
                'dt_publicacao' => $attributes['dt_publicacao'],
                'dt_disputa' => $attributes['dt_abertura'],
                'nm_pregao' => $attributes['nmNumeroEdital'],
                'nm_area' => $attributes['nmArea'],
                'nm_subarea' => $attributes['nmSubarea'],
                'nm_processo' => $attributes['nmNumeroProcesso'],
                'nm_anexo_principal' => $attributes['nmAnexo'],
                'nm_link_anexo' => $attributes['nmLinkAnexo'],
            ]);
        }

        return false;
    }
}
