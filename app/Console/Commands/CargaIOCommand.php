<?php

namespace App\Console\Commands;

use App\Repository\LicitacaoIORepository;
use Forseti\Bot\IO\Enums\LicitacaoEnums;
use Forseti\Bot\IO\PageObject\LicitacaoDetalhesPageObject;
use Forseti\Bot\IO\PageObject\LicitacaoPageObject;
use Forseti\Bot\IO\Seguro\Crawler\ParseLicitacao;
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
     * @var LicitacaoIORepository
     */
    private $repository;

    /**
     * @var LicitacaoPageObject
     */
    private $licPageObject;

    /**
     * @var LicitacaoDetalhesPageObject
     */
    private $licDetPageObject;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LicitacaoPageObject $licPageObject, LicitacaoDetalhesPageObject $licDetPageObject, LicitacaoIORepository $repository)
    {
        parent::__construct();
        $this->licPageObject = $licPageObject;
        $this->licDetPageObject = $licDetPageObject;
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

            Log::info('Iniciando busca de licitacoes no portal IO');

            $parser = $this->licPageObject->withArea(LicitacaoEnums::AREA_SERVICOS_COMUNS)
                                          ->withSubarea(LicitacaoEnums::SUBAREA_SEGUROS)
                                          ->withModalidade(LicitacaoEnums::MODALIDADE_PREGAO_ELETRONICO)
                                          ->withStatus(LicitacaoEnums::STATUS_EM_ABERTO)
                                          ->post();

            $licitacoes = $parser->getLicitacoesIterator();

            foreach ($licitacoes as $licitacao) {

                $parser = $this->licDetPageObject->get($licitacao['id_licitacao']);

                $this->repository->create($parser->asArray()); //internamente verifica se licitacao é de seguro ou nao existe antes de gravar

            }

        } catch (\Exception $e) {

            Log::warning('Erro ao buscar licitacoes do portal IO', ['licitacao' => $licitacao['id_licitacao'], 'exception' => $e->getMessage()]);

        }

        return;
    }
}
