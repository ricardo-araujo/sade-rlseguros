<?php

namespace App\Jobs;

use App\Events\LicitacaoCreatedEvent;
use App\Repository\LicitacaoBBRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class LicitacaoBBReceivedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $oportunidade;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $oportunidade)
    {
        $this->oportunidade = $oportunidade;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LicitacaoBBRepository $repository)
    {
        $licitacao = $repository->create($this->oportunidade);

        if ($licitacao) {

            Log::info('Oportunidade inserida no banco de dados', ['licitacao' => $licitacao->toArray()]);

            event(new LicitacaoCreatedEvent($licitacao));

        } else {

            Log::info('Oportunidade ja existente ou com modalidade incorreta', ['oportunidade' => $this->oportunidade]);

        }
    }
}
