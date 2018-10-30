<?php

namespace App\Jobs;

use App\Models\LicitacaoCN;
use Forseti\Bot\CN\PageObject\ConsultaLicitacoes\DownloadPage;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class DownloadAnexosCNJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var LicitacaoCN
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param LicitacaoCN|Model $licitacao
     */
    public function __construct(LicitacaoCN $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @param DownloadPage $download
     * @return void
     */
    public function handle(DownloadPage $download)
    {
        Log::debug('Iniciando download dos anexos da licitacao no CN', ['licitacao' => $this->licitacao->id]);

        $this->delete();

        while (!$this->licitacao->has_anexo) {

            $path = anexos_path($this->licitacao);

            try {

                $parser = $download->get($this->licitacao->nu_uasg, $this->licitacao->nm_pregao, $this->licitacao->nu_modalidade);

                preg_match('#filename="(.*)"#', $parser->getHeaders()['Content-Disposition'][0], $match);

                $nome = $match[1] ?? 'anexos.zip';

                $parser->save($path . $nome);

                $this->licitacao->update(['has_anexo' => true]);

            } catch (\Exception $e) {

                Log::warning('Erro ao tentar download de anexos da licitacao no CN', ['licitacao' => $this->licitacao->id, 'exception' => $e->getMessage()]);

                dispatch(new self($this->licitacao))->onQueue('cn'); //simula um 'while (true)' do SADE original, enquanto nao baixar os anexos, reinicia o mesmo job.
            }
        }
    }
}
