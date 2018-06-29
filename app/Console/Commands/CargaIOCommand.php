<?php

namespace App\Console\Commands;

use App\Repository\LicitacaoIORepository;
use Forseti\Bot\IO\Seguro\Crawler\ParseLicitacao;
use Forseti\Bot\IO\Seguro\Crawler\ParseListaLicitacao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CargaIOCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:carga-io';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Captura licitações do portal Imprensa Oficial no dia atual';

    /**
     * @var ParseListaLicitacao
     */
    private $parserList;

    /**
     * @var LicitacaoIORepository
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ParseListaLicitacao $parserList, LicitacaoIORepository $repository)
    {
        parent::__construct();
        $this->parserList = $parserList;
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {

            $licitacoes = $this->parserList->getAllLicitacao();

            Log::info('Iniciando busca de licitacoes no portal IO');

            foreach ($licitacoes as $numeroLicitacao) {

                $licitacao = (new ParseLicitacao((int) $numeroLicitacao))->parseData();

                $this->repository->create($licitacao); //internamente verifica se licitacao é de seguro ou nao existe antes de gravar
            }

        } catch (\Exception $e) {

            Log::warning('Erro ao buscar licitacoes do portal IO', ['licitacao' => $numeroLicitacao, 'exception' => $e->getMessage()]);

        }

        return;
    }
}
