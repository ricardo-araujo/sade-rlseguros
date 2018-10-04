<?php

namespace App\Jobs;

use App\Models\OrgaoMapfre;
use Forseti\Bot\Sade\Enums\SadeRamos;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class IdentificaRamoReservaJob implements ShouldQueue
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
        $ramosCollection = collect(SadeRamos::RAMOS);

        $ramosCollection
            ->filter(function($ramos, $regex) {
                return preg_match($regex, $this->licitacao->txt_objeto);
            })
            ->values()
            ->flatten()
            ->unique()
            ->each(function($ramo) {
                dispatch(new CriaReservaJob($this->licitacao, $this->orgao, $ramo))->onQueue($this->licitacao->portal);
            });
    }
}
