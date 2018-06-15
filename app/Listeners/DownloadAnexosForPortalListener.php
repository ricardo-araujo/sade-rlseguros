<?php

namespace App\Listeners;

use App\Events\LicitacaoCreatedEvent;
use App\Jobs\BuscaCnpjsNosAnexosBBJob;
use App\Jobs\BuscaOrgaoNoBecIOJob;
use App\Jobs\DownloadAnexosBBJob;
use App\Jobs\DownloadAnexosCNJob;
use App\Jobs\DownloadAnexosIOJob;
use App\Jobs\EnviaParaMapfreJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DownloadAnexosForPortalListener
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
    public function handle(LicitacaoCreatedEvent $event)
    {
        $licitacao = $event->licitacao;

        if ($licitacao->portal == 'bb')
            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosBBJob($licitacao),
                new ProcessaAnexosJob($licitacao),
                new BuscaCnpjsNosAnexosBBJob($licitacao),
                /**
                 * TODO: criação de orgaos e reserva
                */
                new EnviaParaMapfreJob($licitacao)
            ])->dispatch($licitacao)
              ->allOnQueue('bb');

        if ($licitacao->portal == 'cn')
            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosCNJob($licitacao),
                new ProcessaAnexosJob($licitacao),
                new EnviaParaMapfreJob($licitacao)
            ])->dispatch($licitacao)
              ->allOnQueue('cn')
              ->delay(
                  $this->setDelayTime()
              );

        if ($licitacao->portal == 'io')
            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosIOJob($licitacao),
                new ProcessaAnexosJob($licitacao),
                new BuscaOrgaoNoBecIOJob($licitacao),
                /**
                 * TODO: validacao de orgao e criacao da reserva
                */
                new EnviaParaMapfreJob($licitacao)
            ])->dispatch($licitacao)
              ->allOnQueue('io');
    }

    private function setDelayTime() //6:10 foi um horario padrao observado em que o CN libera os editais
    {
        $jobTime = hour(06, 10, 00);
        $currentTime = now();
        $diff = $currentTime->diffInSeconds($jobTime, false);

        return ($diff < 0 ) ? 0 : $currentTime->addSeconds($diff);
    }
}