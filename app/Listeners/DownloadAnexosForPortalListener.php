<?php

namespace App\Listeners;

use App\Events\LicitacaoCreatedEvent;
use App\Jobs\BuscaCnpjsNosAnexosJob;
use App\Jobs\BuscaOrgaoParaLicitacaoIOJob;
use App\Jobs\DownloadAnexosBBJob;
use App\Jobs\DownloadAnexosCNJob;
use App\Jobs\DownloadAnexosIOJob;
use App\Jobs\EnviaParaMapfreJob;
use App\Jobs\ProcessaAnexosJob;
use App\Jobs\ProcessaLicitacaoJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;

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
                new BuscaCnpjsNosAnexosJob($licitacao),
                /**
                 * TODO: varredura de arquivos p/ busca de cnpjs, criação de orgaos e reserva
                */
                new EnviaParaMapfreJob($licitacao)
            ])->dispatch($licitacao);

        if ($licitacao->portal == 'cn')
            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosCNJob($licitacao),
                new ProcessaAnexosJob($licitacao),
                new EnviaParaMapfreJob($licitacao)
            ])->dispatch($licitacao)
              ->delay(
                  $this->setDelayTime()
              );

        if ($licitacao->portal == 'io')
            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosIOJob($licitacao),
                new ProcessaAnexosJob($licitacao),
                /**
                 * TODO: validacao de orgao e criacao da reserva
                */
                new EnviaParaMapfreJob($licitacao)
            ])->dispatch($licitacao);
    }

    private function setDelayTime() //atrasa a sequencia de jobs p/ as 6:10, p/ que nao estresse o IO com requisicoes de download do edital
    {
        $jobTime = Carbon::createFromTime(06, 10, 00);
        $diffInSeconds = now()->diffInSeconds($jobTime, false);

        return ($diffInSeconds < 0) ? 0 : now()->addSeconds($diffInSeconds);
    }
}