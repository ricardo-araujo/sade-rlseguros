<?php

namespace App\Listeners;

use App\Events\ReservaCNCreatedEvent;
use App\Jobs\AtribuiProxyReservaCNJob;
use App\Jobs\ProcessaReservaJob;
use App\Jobs\ValidaReservaJob;
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
     * Cria fila para atribuir proxies logados em reservas cadastradas pelo usuario.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ReservaCNCreatedEvent $event)
    {
        $reserva = $event->reserva;

        ProcessaReservaJob::withChain([
            new ValidaReservaJob($reserva),
            new AtribuiProxyReservaCNJob($reserva)
        ])->dispatch($reserva)
          ->allOnQueue('cn');
    }
}
