<?php

namespace App\Jobs;

use App\Models\OrgaoMapfre;
use Forseti\Bot\Sade\Pipeline\CreateOrgaoPipeline;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\HandlerStack;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CriaOrgaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    private $licitacao;

    /**
     * @var OrgaoMapfre
     */
    private $orgao;

    /**
     * Create a new job instance.
     *
     * @param Model $licitacao
     * @param OrgaoMapfre $orgao
     */
    public function __construct(Model $licitacao, OrgaoMapfre $orgao)
    {
        $this->licitacao = $licitacao;
        $this->orgao = $orgao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();

        $client = new Client([
            'handler' => app(HandlerStack::class), //provider de Handler de retry, fiz o provider para nao poluir essa classe
            'cookies' => new FileCookieJar(storage_path('default.txt'), true),
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36'
            ]
        ]);

        $parser = (new CreateOrgaoPipeline($client))->process($this->orgao->nm_cnpj, env('FORSETI_PROXY'));

        if ($parser->orgaoInvalido())
            return;

        $this->orgao->update(['nm_razao_social' => $parser->getNome(), 'nm_cod_mapfre' => $parser->getCodigo()]);

        dispatch(new IdentificaRamoReservaJob($this->licitacao, $this->orgao))->onQueue($this->licitacao->portal);
    }
}
