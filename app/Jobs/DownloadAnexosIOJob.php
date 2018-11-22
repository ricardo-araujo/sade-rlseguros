<?php

namespace App\Jobs;

use App\Models\LicitacaoIO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
     * @param Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        Log::debug('Iniciando download dos anexos da licitacao', ['portal' => $this->licitacao->portal, 'licitacao' => $this->licitacao->id]);

        $this->delete();

        $path = anexos_path($this->licitacao);

        try {

            @mkdir($path, 0775, true);

            $response = $client->request('GET', $this->licitacao->nm_link_anexo);

            preg_match('#filename="(.*)"#', $response->getHeader('Content-Disposition')[0],$m);

            $nome = $m[1] ?? 'anexos.zip';

            file_put_contents($path . $nome, $response->getBody()->getContents());

        } catch (GuzzleException | \Exception $e) {

            Log::error('Erro ao tentar download de anexos da licitacao no IO', ['licitacao' => $this->licitacao->id, 'exception' => $e->getMessage()]);

        }
    }
}
