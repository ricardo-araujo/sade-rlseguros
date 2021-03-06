<?php

namespace App\Listeners;

use App\Events\LicitacaoIOCreatedEvent;
use App\Jobs\BuscaOrgaoNoBecIOJob;
use App\Jobs\DownloadAnexosIOJob;
use App\Jobs\IdentificaOrgaoMapfreJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LicitacaoIOCreatedListener
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
    public function handle(LicitacaoIOCreatedEvent $event)
    {
        $licitacao = $event->licitacao;

        ProcessaLicitacaoJob::withChain([
            new DownloadAnexosIOJob($licitacao),
            new ProcessaAnexosJob($licitacao),
            new BuscaOrgaoNoBecIOJob($licitacao),
            new IdentificaOrgaoMapfreJob($licitacao)
        ])->dispatch($licitacao)
          ->allOnQueue('io');
    }
}
