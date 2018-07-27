<?php

namespace App\Listeners;

use App\Events\LicitacaoBBCreatedEvent;
use App\Jobs\BuscaCnpjsNosAnexosBBJob;
use App\Jobs\DownloadAnexosBBJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use App\Jobs\ValidaOrgaoParaLicitacaoJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LicitacaoBBCreatedListener
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
    public function handle(LicitacaoBBCreatedEvent $event)
    {
        $licitacao = $event->licitacao;

        ProcessaLicitacaoJob::withChain([
            new DownloadAnexosBBJob($licitacao),
            new ProcessaAnexosJob($licitacao),
            new BuscaCnpjsNosAnexosBBJob($licitacao),
            new ValidaOrgaoParaLicitacaoJob($licitacao),
            /**
             * TODO: criação de orgaos e reserva
             */
        ])->dispatch($licitacao)
          ->allOnQueue('bb');
    }
}
