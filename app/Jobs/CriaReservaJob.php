<?php

namespace App\Jobs;

use App\Models\OrgaoMapfre;
use App\Repository\ProxyListRepository;
use Forseti\Bot\Sade\Enums\SadeLink;
use Forseti\Bot\Sade\Pipeline\CreateReservaPipeline;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\HandlerStack;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class CriaReservaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    private $licitacao;

    /**
     * @var Model
     */
    private $orgao;

    private $ramo;

    /**
     * Create a new job instance.
     *
     * @param Model $licitacao
     */
    public function __construct(Model $licitacao, OrgaoMapfre $orgao, $ramo)
    {
        $this->licitacao = $licitacao;
        $this->orgao = $orgao;
        $this->ramo = $ramo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();

        if (!$proxy = (new ProxyListRepository())->proxy()) {

            dispatch(new self($this->licitacao, $this->orgao, $this->ramo))->onQueue($this->licitacao->portal)->delay(10);

            return;
        }

        Log::info('Tentando criar reserva na Mapfre', ['licitacao' => $this->licitacao->id, 'orgao' => $this->orgao->id, 'ramo' => $this->ramo]);

        $client = new Client([
            'handler' => app(HandlerStack::class), //provider de Handler de retry, fiz o provider para nao poluir essa classe
            'proxy' => $proxy->proxy,
            'cookies' => new FileCookieJar(storage_path("{$proxy->nome}.txt"), true),
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36'
            ]
        ]);

        $parser = (new CreateReservaPipeline($client))->process($this->orgao->nm_cod_mapfre,
                                                                $this->licitacao->nm_pregao,
                                                                $this->ramo,
                                                                $this->licitacao->dt_disputa);

        if (!$parser->getNumero())
            return;

        $reserva = $this->licitacao->reserva()->create(['nm_reserva' => $parser->getNumero()]);

        $proxy->reserva()->associate($reserva)->save();
    }
}
