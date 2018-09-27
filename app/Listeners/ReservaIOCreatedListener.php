<?php

namespace App\Listeners;

use App\Events\ReservaIOCreatedEvent;
use App\Jobs\AnexaEditalNaReservaJob;
use App\Jobs\ProcessaReservaJob;
use App\Jobs\ValidaReservaJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservaIOCreatedListener
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
    public function handle(ReservaIOCreatedEvent $event)
    {
        $reserva = $event->reserva;

        ProcessaReservaJob::withChain([
            new ValidaReservaJob($reserva),
            new AnexaEditalNaReservaJob($reserva),
        ])->dispatch($reserva)
          ->onQueue('io');
    }
}
