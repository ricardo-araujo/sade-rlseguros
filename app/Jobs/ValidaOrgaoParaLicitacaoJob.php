<?php

namespace App\Jobs;

use App\Models\OrgaoMapfre;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ValidaOrgaoParaLicitacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param Model $licitacao
     */
    public function __construct(Model $licitacao)
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
