<?php

namespace App\Observers;

use App\Events\LicitacaoCreatedEvent;
use App\Jobs\DownloadAnexosCNJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use App\Models\LicitacaoCN;

class LicitacaoCNObserver
{
    public function created(LicitacaoCN $licitacao)
    {
        event(new LicitacaoCreatedEvent($licitacao));

        ProcessaLicitacaoJob::withChain([
            new DownloadAnexosCNJob($licitacao),
            new ProcessaAnexosJob($licitacao)
        ])->dispatch($licitacao)
          ->allOnQueue('cn')
          ->delay(
              $this->setDelayTime()
          );
    }

    private function setDelayTime() //6:10 foi um horario padrao observado em que o CN libera os editais
    {
        $jobTime = hour(06, 10, 00);
        $currentTime = now();
        $diff = $currentTime->diffInSeconds($jobTime, false);

        return ($diff < 0 ) ? 0 : $currentTime->addSeconds($diff);
    }
}
