<?php

namespace App\Repository;

use App\Models\ProxyList;

class ProxyListRepository extends Repository
{
    protected $model = ProxyList::class;

    public function all()
    {
        return $this->query()->get();
    }

    public function create(array $attributes)
    {
        return $this->query()->create($attributes);
    }

    public function deleteById($id)
    {
        return $this->byId($id)->delete();
    }

    public function firstWithDeletedIncludedByName($name)
    {
        return $this->query()
                    ->where('nome', $name)
                    ->withTrashed()
                    ->first();
    }

    public function proxy() //retorna primeiro proxy usado ha mais de 2 minutos ou nao usado e sem reserva associada ou falso
    {
        $model = $this->query()
                      ->where('used_at', '<=', now()->subMinutes(2))
                      ->orWhereNull('used_at')
                      ->whereNull('reserva_id')
                      ->sharedLock()
                      ->first();

        if (!$model)
            return false;

        $model->update(['used_at' => now()]);

        return $model;
    }
}