<?php

namespace App\Listeners;

use App\Events\ReservaCNCreatedEvent;
use App\Jobs\AnexaEditalNaReservaJob;
use App\Jobs\ProcessaReservaJob;
use App\Jobs\ValidaReservaCNJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservaCNCreatedListener
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
    public function handle(ReservaCNCreatedEvent $event)
    {
        $reserva = $event->reserva;

        ProcessaReservaJob::withChain([
            new ValidaReservaCNJob($reserva),
            new AnexaEditalNaReservaJob($reserva)
        ])->dispatch($reserva)
          ->onQueue('cn');;
    }
}
