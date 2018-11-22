<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza backup da base de dados do Sade';

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
     * @return void
     */
    public function handle()
    {
        try {

            $database = env('DB_DATABASE');
            $user = env('DB_USERNAME');
            $password = env('DB_PASSWORD');

            $file = database_path(sprintf('sade_new_%s.sql', today()->format('Ymd')));

            $this->info("Salvando backup em {$file}");

            $process = new Process(sprintf('mysqldump -u %s -p%s --databases %s > %s', $user, $password, $database, $file)); //realiza o dump na pasta storage da aplicação
            $process->run();

            $this->info('Removendo arquivos anteriores');

            $process = new Process(sprintf('find %s -maxdepth 1 -type f -mtime +1 | xargs rm', database_path('*.sql'))); // busca todos os arquivos sql em storage criados a mais de 1 dia e remove-o p/ manter versao mais atual
            $process->run();

            $this->info('Finalizado!');

        } catch (\Exception $e) {

            $this->error($e->getMessage());

        }
    }
}
