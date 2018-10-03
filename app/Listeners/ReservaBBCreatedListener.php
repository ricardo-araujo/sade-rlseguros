<?php

namespace App\Listeners;

use App\Events\ReservaBBCreatedEvent;
use App\Jobs\AnexaEditalNaReservaJob;
use App\Jobs\ProcessaReservaJob;
use App\Jobs\ValidaReservaJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservaBBCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ReservaBBCreatedEvent $event)
    {
        $reserva = $event->reserva;

        ProcessaReservaJob::withChain([
            new ValidaReservaJob($reserva),
            new AnexaEditalNaReservaJob($reserva),
        ])->dispatch($reserva)
          ->allOnQueue('bb');
    }
}
