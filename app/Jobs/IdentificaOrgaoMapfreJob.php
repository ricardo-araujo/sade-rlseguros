<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class IdentificaOrgaoMapfreJob implements ShouldQueue
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

        if ($this->licitacao->portal === 'bb')
            dispatch(new IdentificaOrgaoMapfreBBJob($this->licitacao))->onQueue('bb');

        if ($this->licitacao->portal === 'io')
            dispatch(new IdentificaOrgaoMapfreIOJob($this->licitacao))->onQueue('io');
    }
}
