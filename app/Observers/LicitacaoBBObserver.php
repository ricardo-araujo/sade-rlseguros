<?php

namespace App\Observers;

use App\Events\LicitacaoCreatedEvent;
use App\Jobs\BuscaCnpjsNosAnexosBBJob;
use App\Jobs\DownloadAnexosBBJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use App\Jobs\ValidaOrgaoParaLicitacaoJob;
use App\Models\LicitacaoBB;

class LicitacaoBBObserver
{
    public function created(LicitacaoBB $licitacao)
    {
        event(new LicitacaoCreatedEvent($licitacao));

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
