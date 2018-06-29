<?php

namespace App\Observers;

use App\Jobs\AnexaEditalNaReservaJob;
use App\Jobs\ProcessaReservaJob;
use App\Jobs\ValidaReservaCNJob;
use App\Models\ReservaCN;

class ReservaCNObserver
{
    public function created(ReservaCN $reserva)
    {
        ProcessaReservaJob::withChain([
            new ValidaReservaCNJob($reserva),
            new AnexaEditalNaReservaJob($reserva)
        ])->dispatch($reserva)
          ->onQueue('cn');
    }
}
