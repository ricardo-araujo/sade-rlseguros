<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RemoveCookiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:remove-cookies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca no diretorio storage os arquivos txt, criados pela validacao da reserva e remove-os';

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
        $process = new Process(sprintf('find %s -maxdepth 1 -type f | xargs rm', storage_path('*.txt')));
        $process->run();

        return;
    }
}
