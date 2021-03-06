<?php

namespace App\Jobs;

use App\Models\AbstractLicitacao;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessaLicitacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AbstractLicitacao $licitacao)
    {
        /**
         * Classe wrapper pra juntar os processos de processamento de uma licitacao para cada portal
         *
         * https://laravel.com/docs/5.6/queues#job-chaining
        */
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
