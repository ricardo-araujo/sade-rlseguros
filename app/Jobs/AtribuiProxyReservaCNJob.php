<?php

namespace App\Jobs;

use App\Models\AbstractReserva;
use App\Repository\ProxyListRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AtribuiProxyReservaCNJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public $timeout = 1000;

    /**
     * @var AbstractReserva
     */
    private $reserva;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AbstractReserva $reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        while (!$proxy = (new ProxyListRepository())->proxy())
            sleep(5);

        $proxy->reserva()->associate($this->reserva)->save();
    }
}
