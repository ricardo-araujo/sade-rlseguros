<?php

namespace App\Observers;

use App\Events\ReservaCNCreatedEvent;
use App\Models\ReservaCN;

class ReservaCNObserver
{
    public function created(ReservaCN $reservaCN)
    {
        event(new ReservaCNCreatedEvent($reservaCN));
    }
}
