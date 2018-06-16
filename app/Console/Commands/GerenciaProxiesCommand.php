<?php

namespace App\Console\Commands;

use App\Models\ProxyList;
use App\Repository\ProxyListRepository;
use Illuminate\Console\Command;

class GerenciaProxiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:gerencia-proxy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adiciona, altera, restaura ou exclui do bd, os proxies  para anexar o edital à reserva';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * @var ProxyList
     */
    private $proxy;

    /**
     * @var ProxyListRepository
     */
    private $repository;

    public function __construct(ProxyListRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $proxyName = $this->ask('Digite o nome do proxy:');

        $this->proxy = $this->repository->firstWithDeletedIncludedByName($proxyName);

        if (!$this->proxy) {

            return $this->addProxy($proxyName);

        } else if ($this->proxy->trashed()) { //verifica se proxy existe mas está inativo (soft-deleted)

            return $this->restoreProxy();

        } else {

            return $this->manageProxy();

        }
    }

    private function addProxy($proxyName)
    {
        if ($this->confirm('Proxy não existe no banco de dados. Deseja adicioná-lo?')) {

            $ip = $this->ask('Digite o ip do proxy:');

            $port = $this->ask('Digite a porta do proxy:');

            $type = $this->ask('Digite o tipo do proxy (tcp, http, socks5...):');

            $this->repository->create(['nome' => $proxyName, 'proxy' => "{$type}://{$ip}:{$port}"]);

            $this->info("Proxy {$proxyName} criado com sucesso!");
        }
    }

    private function restoreProxy()
    {
        if ($this->confirm('O proxy está inativo no banco de dados. Deseja restaurá-lo?')) {

            $this->proxy->restore();

            $this->info("Proxy {$this->proxy->nome} restaurado com sucesso!");
        }
    }

    private function manageProxy()
    {
        $answer = $this->choice('Proxy já existe no banco de dados, deseja alterá-lo ou excluí-lo?', ['alterar', 'excluir']);

        if ($answer == 'alterar') {

            $ip = $this->ask('Digite o ip do proxy:');

            $port = $this->ask('Digite a porta do proxy:');

            $type = $this->ask('Digite o tipo do proxy:');

            $this->proxy->update(['proxy' => "{$type}://{$ip}:{$port}"]);

            $this->info("Proxy {$this->proxy->nome} alterado com sucesso!");
        }

        if ($answer == 'excluir') {

            $this->proxy->delete();

            $this->info("Proxy {$this->proxy->nome} excluido com sucesso!");
        }
    }
}