<?php

namespace App\Jobs;

use App\Models\LicitacaoIO;
use Forseti\Bot\IO\PageObject\LicitacaoDownloadEditalPageObject;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class DownloadAnexosIOJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var LicitacaoIO
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param LicitacaoIO|Model $licitacao
     */
    public function __construct(LicitacaoIO $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LicitacaoDownloadEditalPageObject $po)
    {
        $this->delete();

        Log::debug('Iniciando download dos anexos da licitacao', ['portal' => $this->licitacao->portal, 'licitacao' => $this->licitacao->id]);

        try {

            $path = anexos_path($this->licitacao);

            @mkdir($path, 0775, true);

            $po->get($this->licitacao->nm_link_anexo)->saveTo($path);

        } catch (\Exception $e) {

            Log::error('Erro ao tentar download de anexos da licitacao no IO', ['licitacao' => $this->licitacao->id, 'exception' => $e->getMessage()]);

        }
    }
}
