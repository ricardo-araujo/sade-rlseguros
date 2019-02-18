<?php

namespace App\Jobs;

use App\Models\LicitacaoCN;
use Forseti\Bot\CN\PageObject\ConsultaLicitacoes\PesquisarUasgPage;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BuscaOrgaoCNJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var LicitacaoCN
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param LicitacaoCN|Model $licitacao
     */
    public function __construct(LicitacaoCN $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PesquisarUasgPage $pageObject)
    {
        $orgao = $pageObject->get($this->licitacao->nu_uasg)->getNomeUasg();

        $this->licitacao->update(['nm_orgao' => $orgao]);
    }
}
