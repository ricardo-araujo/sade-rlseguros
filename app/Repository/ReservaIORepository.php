<?php

namespace App\Repository;

use App\Models\ReservaIO;

class ReservaIORepository extends Repository
{
    protected $model = ReservaIO::class;

    public function existsToday()
    {
        return $this->query()
                     ->whereDate('created_at', today())
                     ->whereNotNull('was_uploaded')
                     ->exists();
    }

    public function create($nmReserva)
    {
        return $this->query()->create(['nm_reserva' => $nmReserva]);
    }

    public function searchAndDelete($numero)
    {
        return $this->query()->where('nm_reserva', $numero)->delete();
    }
}
