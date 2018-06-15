<?php

namespace App\Repository;

use App\Models\OrgaoMapfre;

class OrgaoMapfreRepository extends Repository
{
    protected $model = OrgaoMapfre::class;

    public function firstOrCreate($cnpj, $razaoSocial)
    {
        return $this->query()->firstOrCreate(['nm_cnpj' => $cnpj], ['nm_razao_social' => $razaoSocial]);
    }
}