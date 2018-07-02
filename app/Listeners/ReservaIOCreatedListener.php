<?php

namespace App\Listeners;

use App\Events\ReservaIOCreatedEvent;
use App\Jobs\AnexaEditalNaReservaJob;
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

        dispatch(new AnexaEditalNaReservaJob($reserva))->onQueue('io');
    }
}
