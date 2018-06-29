<?php

namespace App\Jobs;

use App\Models\AbstractLicitacao;
use App\Models\OrgaoMapfre;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ValidaOrgaoParaLicitacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AbstractLicitacao
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AbstractLicitacao $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();

        if ($this->licitacao->portal == 'io')

            ($this->licitacao->orgao->nm_cod_mapfre)
                ? dispatch(new CriaReservaJob($this->licitacao))->onQueue('io')
                : dispatch(new CriaOrgaoJob($this->licitacao, $this->licitacao->orgao))->onQueue('io');

        if ($this->licitacao->portal == 'bb')

            $this->licitacao->orgao->each(function(OrgaoMapfre $orgao) {
                ($orgao->nm_cod_mapfre)
                    ? dispatch(new CriaReservaJob($this->licitacao))->onQueue('bb')
                    : dispatch(new CriaOrgaoJob($this->licitacao, $orgao))->onQueue('bb');
            });

        return;
    }
}