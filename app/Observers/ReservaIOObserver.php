<?php

namespace App\Observers;

use App\Events\ReservaIOCreatedEvent;
use App\Models\ReservaIO;

class ReservaIOObserver
{
    public function created(ReservaIO $reserva)
    {
        event(new ReservaIOCreatedEvent($reserva));
    }
}
