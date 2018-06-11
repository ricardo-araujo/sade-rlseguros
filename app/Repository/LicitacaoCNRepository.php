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
                 ->where([['nu_pregao', '=', $attributes['nu_pregao']], ['nu_uasg', '=', $attributes['nu_uasg']]])
                 ->doesntExist()) {

            return $this->query()->create([
                'nm_uf' => $attributes['uf'],
                'nm_orgao' => app()->make(PesquisarUasgPage::class)->get($attributes['nu_uasg'])->getNomeUasg(),
                'nu_uasg' => $attributes['nu_uasg'],
                'txt_objeto' => $attributes['objeto'],
                'nu_pregao' => $attributes['nu_pregao'],
                'nm_endereco' => $attributes['endereco'],
                'nm_fax' => $attributes['fax'],
                'nm_telefone' => $attributes['telefone'],
                'dt_entrega_proposta' => $attributes['entregaProposta'],
                'dt_abertura_proposta' => $attributes['aberturaProposta'],
                'nu_modalidade' => $attributes['nu_modalidade'],
                'nm_modalidade' => $attributes['modalidade']
            ]);
        }
    }

    public function toBeProcessed()
    {
        return $this->query()
                     ->whereDate('created_at', today('America/Sao_Paulo'))
                     ->where('has_anexo', false)
                     ->get();
    }
}