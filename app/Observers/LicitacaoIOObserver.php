<?php

namespace App\Observers;

use App\Events\LicitacaoCreatedEvent;
use App\Jobs\BuscaOrgaoNoBecIOJob;
use App\Jobs\DownloadAnexosIOJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use App\Jobs\ValidaOrgaoParaLicitacaoJob;
use App\Models\LicitacaoIO;

class LicitacaoIOObserver
{
    public function created(LicitacaoIO $licitacao)
    {
        event(new LicitacaoCreatedEvent($licitacao));

        ProcessaLicitacaoJob::withChain([
            new DownloadAnexosIOJob($licitacao),
            new ProcessaAnexosJob($licitacao),
            new BuscaOrgaoNoBecIOJob($licitacao),
            new ValidaOrgaoParaLicitacaoJob($licitacao),
            /**
             * TODO: validacao de orgao e criacao da reserva
             */
        ])->dispatch($licitacao)
          ->allOnQueue('io');
    }
}