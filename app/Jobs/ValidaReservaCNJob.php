<?php

namespace App\Jobs;

use App\Models\AbstractReserva;
use App\Repository\ProxyListRepository;
use App\Repository\RecaptchaRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ValidaReservaCNJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var AbstractReserva
     */
    private $reserva;

    /**
     * Create a new job instance.
     *
     * @param AbstractReserva|Model $reserva
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
    public function handle(RecaptchaRepository $recaptchaRepo, ProxyListRepository $proxyRepo)
    {
        $this->delete();

        if (!$token = $recaptchaRepo->token() or !$proxy = $proxyRepo->proxy()) {

            dispatch(new self($this->reserva));

            return;
        }

        Log::debug('Validando reserva no site da Mapfre', ['reserva' => $this->reserva->toArray()]);

        /**
         * TODO: finalizar rotina
        */
    }
}
