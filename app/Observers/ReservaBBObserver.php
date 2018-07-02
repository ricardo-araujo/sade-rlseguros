<?php

namespace App\Observers;

use App\Events\ReservaBBCreatedEvent;
use App\Models\ReservaBB;

class ReservaBBObserver
{
    public function created(ReservaBB $reserva)
    {
        event(new ReservaBBCreatedEvent($reserva));
    }
}
