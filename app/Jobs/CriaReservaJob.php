<?php

namespace App\Jobs;

use App\Models\OrgaoMapfre;
use Forseti\Bot\Sade\Pipeline\CreateReservaPipeline;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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

    private $client;

    /**
     * Create a new job instance.
     *
     * @param Model $licitacao
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

        $parser = (new CreateReservaPipeline($client))->process(
            $this->orgao->nm_cod_mapfre,
            $this->licitacao->nm_edital,
            '', /** TODO: Ramo vindo de regex no texto do objeto */
            $this->licitacao->dt_disputa);

        dump($parser);
    }
}
