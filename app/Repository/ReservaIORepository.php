<?php

namespace App\Repository;

use App\Models\ReservaIO;

class ReservaIORepository extends DefaultReservaRepository
{
    protected $model = ReservaIO::class;

    public function create($nmReserva)
    {
        return $this->query()->create(['nm_reserva' => $nmReserva]);
    }
}
