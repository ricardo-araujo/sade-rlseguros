<?php

namespace App\Jobs;

use App\Models\LicitacaoIO;
use App\Repository\OrgaoIORepository;
use Forseti\Bot\Sade\PageObject\GetUnidadeCompradoraPageObject;
use GuzzleHttp\ClientInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BuscaOrgaoParaLicitacaoIOJob implements ShouldQueue
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
    public function handle(ClientInterface $client, OrgaoIORepository $orgaoRepo)
    {
        if ($orgao = $orgaoRepo->firstByUge($this->licitacao->nu_orgao)) {

            $this->licitacao->orgao()->associate($orgao)->save();

            return;
        }

        $parser = (new GetUnidadeCompradoraPageObject($client, $this->licitacao->nu_orgao))->perform();

        if ($parser)
            $this->licitacao->orgao()->associate($orgaoRepo->create($parser))->save();
    }
}
