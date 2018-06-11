<?php

namespace App\Listeners;

use App\Events\LicitacaoCreatedEvent;
use App\Jobs\DownloadAnexosBBJob;
use App\Jobs\DownloadAnexosCNJob;
use App\Jobs\DownloadAnexosIOJob;
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

        if ($licitacao->portal == 'bb') {

            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosBBJob($licitacao),
                new ProcessaAnexosJob($licitacao)
            ])->dispatch($licitacao);

        }

        if ($licitacao->portal == 'cn') {

            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosCNJob($licitacao),
                new ProcessaAnexosJob($licitacao)
            ])->dispatch($licitacao)->delay(self::setDelayTime());

        }

        if ($licitacao->portal == 'io') {

            ProcessaLicitacaoJob::withChain([
                new DownloadAnexosIOJob($licitacao),
                new ProcessaAnexosJob($licitacao)
            ])->dispatch($licitacao);

        }
    }

    /**
     * Checa o horario da oportunidade para que as requisições do job se iniciem exatamente às 06h10, que é uma estimativa do horario que o CN
     *
     * libera seus anexos e evita do sistema estressar o portal com muitas requisicoes para verificar se ja estão disponíveis.
     */
    private static function setDelayTime()
    {
        $jobTime = Carbon::createFromTime(06, 10, 00); //hora em que requisicoes para download devem se iniciar no portal do CN
        $diffInSeconds = now()->diffInSeconds($jobTime, false);

        return ($diffInSeconds < 0) ? 0 : now()->addSeconds($diffInSeconds);
    }
}