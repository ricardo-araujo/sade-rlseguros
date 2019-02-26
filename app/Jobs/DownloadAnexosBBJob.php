<?php

namespace App\Jobs;

use App\Models\LicitacaoBB;
use Forseti\Bot\BB\Crawler\DocumentoCrawler;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class DownloadAnexosBBJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var LicitacaoBB
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param LicitacaoBB|Model $licitacao
     */
    public function __construct(LicitacaoBB $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DocumentoCrawler $crawler)
    {
        $this->delete();

        Log::debug('Iniciando download dos anexos da licitacao', ['portal' => $this->licitacao->portal, 'licitacao' => $this->licitacao->id]);

        $links = $this->licitacao->nm_link_anexo; //caso nao seja nulo, retorna um array, devido aos accessors do Laravel

        $path = anexos_path($this->licitacao);

        foreach ($links as $link) {

            try {

                $crawler->get($this->licitacao->nu_licitacao, $link['nu_anexo'])->save($path . $link['nm_arquivo']);

            } catch (\Exception $e) {

                Log::error('Erro ao tentar download de anexos da licitacao no BB', ['licitacao' => $this->licitacao->id, 'exception' => $e->getMessage()]);

                dispatch(new self($this->licitacao))->onQueue('bb');

            }
        }
    }
}
