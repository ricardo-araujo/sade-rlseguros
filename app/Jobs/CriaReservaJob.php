<?php

namespace App\Jobs;

use App\Models\AbstractLicitacao;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CriaReservaJob implements ShouldQueue
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
        // rotina de criação de reserva no bot sade...
    }
}
