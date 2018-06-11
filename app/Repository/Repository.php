<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe feita para não sujar os controllers com regras de acesso a banco de dados
 */
abstract class Repository
{
    /**
     * Model a ser informado na classe filha
     *
     * @var Model
    */
    protected $model;

    /**
     * @return Builder
     */
    protected function query()
    {
        $model = app()->make($this->model);

        return $model->newQuery();
    }

    public function byId($id)
    {
        return $this->query()->find($id);
    }

    public function fromDate(\DateTime $date)
    {
        return $this->query()->whereDate('created_at', $date->format('Y-m-d'))->orderBy('created_at')->get();
    }
}