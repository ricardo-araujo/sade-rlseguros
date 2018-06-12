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

    public function proxy()
    {
        $model = $this->query()
                      ->where('used_at', '<=', now()->subMinutes(2)) //retorna primeiro proxy usado a mais de 2 minutos ou nao usado e sem reserva associada ou falso
                      ->orWhereNull('used_at')
                      ->whereNull('id_reserva')
                      ->sharedLock()
                      ->first();

        if (!$model)
            return false;

        $model->update(['used_at' => now()]);

        return $model;
    }
}