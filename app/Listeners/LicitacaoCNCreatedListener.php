<?php

namespace App\Listeners;

use App\Events\LicitacaoCNCreatedEvent;
use App\Jobs\DownloadAnexosCNJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use App\Jobs\UploadEditalCNJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LicitacaoCNCreatedListener
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
    public function handle(LicitacaoCNCreatedEvent $event)
    {
        $licitacao = $event->licitacao;

        ProcessaLicitacaoJob::withChain([
            new DownloadAnexosCNJob($licitacao),
            new ProcessaAnexosJob($licitacao),
            new UploadEditalCNJob($licitacao)
        ])->dispatch($licitacao)
          ->allOnQueue('cn')
          ->delay(
              $this->setDelayTime()
          );
    }

    private function setDelayTime() //6:10 foi um horario padrao observado em que o CN libera os editais
    {
        $currentTime = now();
        $jobTime = hour(06, 10, 00);
        $diff = $currentTime->diffInSeconds($jobTime, false);

        return ($diff <= 0 ) ? 0 : $currentTime->addSeconds($diff);
    }
}
