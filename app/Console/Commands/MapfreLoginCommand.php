<?php

namespace App\Console\Commands;

use App\Models\ProxyList;
use App\Repository\ProxyListRepository;
use App\Repository\RecaptchaRepository;
use Forseti\Bot\Sade\PageObject\LoginPageObject;
use Forseti\Bot\Sade\Pipeline\LoginPipeline;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\HandlerStack;
use Illuminate\Console\Command;

class MapfreLoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:mapfre-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza login na Mapfre e gera cookie para ações do Sade do dia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = env('USUARIO_MAPFRE');
        $pass = env('SENHA_MAPFRE');

        (new ProxyListRepository())->resetLoggedProxies(); //retorna proxies para nao logado para que sejam validados novamente

        while ($proxies = (new ProxyListRepository())->notLogged()) {

            $proxies->each(function(ProxyList $proxy) use($user, $pass) {

                $client = new Client([
                    'handler' => app(HandlerStack::class), //provider de Handler de retry, fiz o provider para nao poluir essa classe
                    'cookies' => new FileCookieJar(storage_path("{$proxy->nome}.txt"), true),
                    'proxy' => $proxy->proxy,
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36'
                    ]
                ]);

                $this->info("Verificando login do proxy {$proxy->nome}");

                $parser = (new LoginPageObject($client))->getHomepage()();

                if ($parser->isLogged()) {

                    $this->info("Proxy {$proxy->nome} já logado");

                    $proxy->update(['is_logged' => true]);

                } else {

                    $this->info("Proxy {$proxy->nome} não logado. Tentando...");

                    while (!$token = (new RecaptchaRepository())->token())
                        sleep(5);

                    $parser = (new LoginPipeline($client))->process($user, $pass, $token);

                    if ($parser->isLogged()) {

                        $this->info("Proxy {$proxy->nome} logado");

                        $proxy->update(['is_logged' => true]);
                    }
                }
            });
        }

        $this->info('Processo de login para proxies finalizado!');

        return true;
    }
}
