<?php

namespace App\Jobs;

use function Composer\Autoload\includeFile;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class IdentificaOrgaoMapfreIOJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @return void
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

        $orgao = $this->licitacao->orgao;

        if ($orgao->is_manual) {

            $this->fail();

            return;
        }

        (!$orgao->nm_cod_mapfre)
            ? dispatch(new CriaOrgaoJob($licitacao, $orgao))->onQueue('io')
            : dispatch(new IdentificaRamoReservaJob($licitacao, $orgao))->onQueue('io');
    }
}
