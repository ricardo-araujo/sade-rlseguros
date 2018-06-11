<?php

namespace App\Repository;

use App\Models\OrgaoIO;
use Forseti\Bot\Sade\Parser\UnidadeCompradoraParser;

class OrgaoIORepository extends Repository
{
    protected $model = OrgaoIO::class;

    public function create(UnidadeCompradoraParser $orgao)
    {
        return $this->query()->create([
            'nu_uge' => $orgao->getUge(),
            'nu_orgao' => $orgao->getOrgao(),
            'nm_gestao' => $orgao->getGestao(),
            'nm_orgao' => $orgao->getNome(),
            'nm_endereco' => $orgao->getEndereco(),
            'nm_municipio' => $orgao->getMunicipio(),
            'nm_cep' => $orgao->getCep(),
            'nm_email' => $orgao->getEmail(),
            'nm_telefone_1' => $orgao->getTelefoneOne(),
            'nm_telefone_2' => $orgao->getTelefoneTwo(),
            'nm_fax' => $orgao->getFax(),
            'nm_cnpj' => $orgao->getCnpj()
        ]);
    }

    public function firstByUge($nuUge)
    {
        return $this->query()->where(['nu_uge' => $nuUge])->first();
    }
}