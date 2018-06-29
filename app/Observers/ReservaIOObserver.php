<?php

namespace App\Observers;

use App\Jobs\AnexaEditalNaReservaJob;
use App\Models\ReservaIO;

class ReservaIOObserver
{
    public function created(ReservaIO $reserva)
    {
        dispatch(new AnexaEditalNaReservaJob($reserva))->onQueue('io');
    }
}
