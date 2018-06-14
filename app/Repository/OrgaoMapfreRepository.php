<?php

namespace App\Repository;

use App\Models\OrgaoMapfre;

class OrgaoMapfreRepository extends Repository
{
    protected $model = OrgaoMapfre::class;

    public function create()
    {
        return $this->query()->create(); /** TODO: finalizar */
    }

    public function firstByCnpjWithMapfreCode($cnpj)
    {
        return $this->query()
                     ->where(['nm_cnpj' => $cnpj])
                     ->whereNotNull('nm_cod_mapfre')
                     ->first();
    }
}