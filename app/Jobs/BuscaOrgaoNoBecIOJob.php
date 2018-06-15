<?php

namespace App\Jobs;

use App\Models\LicitacaoIO;
use App\Repository\OrgaoMapfreRepository;
use Forseti\Bot\Sade\PageObject\GetUnidadeCompradoraPageObject;
use GuzzleHttp\ClientInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BuscaOrgaoNoBecIOJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var LicitacaoIO
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param LicitacaoIO|Model $licitacao
     */
    public function __construct(LicitacaoIO $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ClientInterface $client, OrgaoMapfreRepository $orgaoRepo)
    {
        $parser = (new GetUnidadeCompradoraPageObject($client, $this->licitacao->nu_orgao))->perform();

        $orgao = $orgaoRepo->firstOrCreate($parser->getCnpj(), $parser->getNome());

        $this->licitacao->orgao()->associate($orgao)->save();
    }
}