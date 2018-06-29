<?php

namespace App\Observers;

use App\Jobs\AnexaEditalNaReservaJob;
use App\Models\ReservaBB;

class ReservaBBObserver
{
    public function created(ReservaBB $reserva)
    {
        dispatch(new AnexaEditalNaReservaJob($reserva))->onQueue('bb');
    }
}
