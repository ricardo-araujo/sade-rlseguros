<?php

namespace App\Jobs;

use App\Models\AbstractLicitacao;
use App\Models\AbstractReserva;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EnviaParaMapfreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AbstractLicitacao
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param AbstractLicitacao|Model $licitacao
     */
    public function __construct(AbstractLicitacao $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->licitacao->reserva->each(function(AbstractReserva $reserva) {

            dispatch(new AnexaEditalNaReservaJob($reserva));

        });
    }
}
