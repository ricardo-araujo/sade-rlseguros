<?php

namespace App\Repository;

use App\Models\ReservaCN;

class ReservaCNRepository extends Repository
{
    protected $model = ReservaCN::class;

    public function searchAndDelete($numero)
    {
        return $this->query()->where('nm_reserva', $numero)->delete();
    }

    public function existsToday()
    {
        return $this->query()
                     ->whereDate('created_at', today())
                     ->whereNotNull('was_uploaded')
                     ->exists();
    }
}