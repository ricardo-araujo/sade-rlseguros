<?php

namespace App\Listeners;

use App\Events\LicitacaoBBCreatedEvent;
use App\Jobs\BuscaCnpjsNosAnexosBBJob;
use App\Jobs\DownloadAnexosBBJob;
use App\Jobs\IdentificaOrgaoMapfreJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
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
            new IdentificaOrgaoMapfreJob($licitacao)
        ])->dispatch($licitacao)
          ->allOnQueue('bb');
    }
}
