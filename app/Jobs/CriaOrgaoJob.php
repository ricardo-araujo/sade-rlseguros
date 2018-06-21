<?php

namespace App\Jobs;

use App\Models\AbstractLicitacao;
use App\Models\OrgaoMapfre;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CriaOrgaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AbstractLicitacao
     */
    private $licitacao;
    /**
     * @var OrgaoMapfre
     */
    private $orgao;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AbstractLicitacao $licitacao, OrgaoMapfre $orgao)
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
        //rotina de criacao de orgao no bot sade...


        dispatch(new CriaReservaJob($this->licitacao));
    }
}
