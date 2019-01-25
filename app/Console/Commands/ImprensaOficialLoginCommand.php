<?php

namespace App\Console\Commands;

use Forseti\Bot\IO\PageObject\LoginPageObject;
use Illuminate\Console\Command;

class ImprensaOficialLoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:imprensa-oficial-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza login no portal do Imprensa Oficial e gera cookie para ações do Sade do dia';

    /**
     * @var LoginPageObject
     */
    private $pageObject;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LoginPageObject $pageObject)
    {
        parent::__construct();
        $this->pageObject = $pageObject;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = env('USUARIO_IMPRENSA_OFICIAL');
        $pass = env('SENHA_IMPRENSA_OFICIAL');

        $this->info('Verificando usuario logado no portal');

        $parser = $this->pageObject->get();

        if ($parser->isLogged()) {

            $this->info('Usuario logado!');

            return true;
        }

        beggining:

        $this->info('Usuario nao logado. Tentando...');

        $parser = $this->pageObject->post($user, $pass);

        while (!$parser->isLogged())
            goto beggining;

        $this->info('Usuario logado!');

        return true;
    }
}
