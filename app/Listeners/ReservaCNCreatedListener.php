<?php

namespace App\Listeners;

use App\Events\ReservaCNCreatedEvent;
use App\Repository\ProxyListRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservaCNCreatedListener implements ShouldQueue
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'cn';

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 20;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 900;

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
        while (!$proxy = (new ProxyListRepository())->proxy())
            sleep(5);

        $reserva = $event->reserva;

        $proxy->reserva()->associate($reserva)->save();
    }
}
