<?php

namespace App\Jobs;

use Forseti\Bot\Sade\Pipeline\CreateReservaPipeline;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CriaReservaJob implements ShouldQueue
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
    public function handle(Client $client)
    {
        $this->delete();

        /**
         * TODO: finalizar rotina e adequar p/ BB e IO
        */
        $parser = (new CreateReservaPipeline($client))->process(
            '',
            $this->licitacao->nm_edital,
            $this->licitacao->nu_ramo,
            $this->licitacao->dt_disputa);

        dump($parser);
    }
}
