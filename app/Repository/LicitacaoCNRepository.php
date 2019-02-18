<?php

namespace App\Repository;

use App\Models\LicitacaoCN;
use Forseti\Bot\CN\PageObject\ConsultaLicitacoes\PesquisarUasgPage;

class LicitacaoCNRepository extends Repository
{
    protected $model = LicitacaoCN::class;

    public function create(array $attributes)
    {
        if ($this->query()
                 ->where([['nm_pregao', '=', $attributes['nu_pregao']], ['nu_uasg', '=', $attributes['nu_uasg']]])
                 ->doesntExist()) {

            return $this->query()->create([
                'portal' => 'cn',
                'nm_uf' => $attributes['uf'],
                'nu_uasg' => $attributes['nu_uasg'],
                'txt_objeto' => $attributes['objeto'],
                'nm_pregao' => $attributes['nu_pregao'],
                'nm_endereco' => $attributes['endereco'],
                'nm_fax' => $attributes['fax'],
                'nm_telefone' => $attributes['telefone'],
                'dt_entrega_proposta' => $attributes['entregaProposta'],
                'dt_abertura_proposta' => $attributes['aberturaProposta'],
                'nu_modalidade' => $attributes['nu_modalidade'],
                'nm_modalidade' => $attributes['modalidade'],
            ]);
        }

        return false;
    }
}
