<?php

namespace App\Console\Commands;

use App\Repository\LicitacaoCNRepository;
use Forseti\Bot\CN\PageObject\ConsultaLicitacoes\ConsLicitacaoRelacaoPage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CargaCNCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:carga-cn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Captura licitações do portal ComprasNet no dia atual';

    /**
     * @var ConsLicitacaoRelacaoPage
     */
    private $consultaPageObject;

    /**
     * @var LicitacaoCNRepository
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConsLicitacaoRelacaoPage $consultaPageObject, LicitacaoCNRepository $repository)
    {
        parent::__construct();
        $this->consultaPageObject = $consultaPageObject;
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Iniciando busca de licitacoes no CN');

        try {

            $data = new \DateTime();

            $parser = $this->consultaPageObject->buscarLicitacaoSeguro($data, $data);

            $pagina = 0; $totalPaginas = $parser->getTotalPaginas();
            while ($totalPaginas >= ++$pagina) {

                $parser = $this->consultaPageObject->buscarLicitacaoSeguro($data, $data, $pagina);

                $it = $parser->getIterator();

                foreach ($it as $licitacao) {

                    $this->repository->create($licitacao); //internamente verifica se licitacao ja existe

                }
            }

            return true;

        } catch (\Exception $e) {

            Log::info('Nenhuma licitacao encontrada' , ['exception' => $e->getMessage()]);

            return false;
        }
    }
}
