<?php

namespace App\Jobs;

use App\Models\LicitacaoBB;
use App\Models\OrgaoMapfre;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class IdentificaOrgaoMapfreBBJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param Model|LicitacaoBB $licitacao
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

        $licitacao = $this->licitacao;

        $licitacao->orgao()
                  ->where('is_manual', '=', false)
                  ->each(function (OrgaoMapfre $orgao) use ($licitacao) {
                      (!$orgao->nm_cod_mapfre)
                          ? dispatch(new CriaOrgaoJob($licitacao, $orgao))->onQueue('bb')
                          : dispatch(new IdentificaRamoReservaJob($licitacao, $orgao))->onQueue('bb');
        });
    }
}
