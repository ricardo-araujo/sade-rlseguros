<?php

namespace App\Console\Commands;

use App\Repository\RecaptchaRepository;
use Forseti\Bot\Sade\PageObject\GetHomePageObject;
use Forseti\Bot\Sade\PageObject\GetLoginPageObject;
use Forseti\Bot\Sade\PageObject\PostLoginPageObject;
use Illuminate\Console\Command;
use League\Pipeline\Pipeline;

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
        while (!$token = (new RecaptchaRepository())->token())
            continue;

        $client = getClient();

        (new Pipeline())
            ->pipe(new GetLoginPageObject($client))
            ->pipe(new PostLoginPageObject($client, $token, env('USUARIO_MAPFRE'), env('SENHA_MAPFRE')))
            ->pipe(new GetHomePageObject($client))
            ->process('');

        return true;
    }
}
