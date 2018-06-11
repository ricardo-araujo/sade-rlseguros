<?php

namespace App\Console\Commands;

use Carbon\Carbon;
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
    protected $description = 'Realiza backup das bases de dados do Sade e exclui backups feitos a mais de 20 dias';

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
        $jobStartTime = Carbon::createFromTime(06, 10, 00);

        $currentTime = Carbon::now();

        $sec1 = $jobStartTime->diffInSeconds($currentTime, false);  // terminar logica para atrasar job de busca de edital da licitacao
                                                                             // caso o horario de captura seja anterior ao jobStartTime, calcular a diferenca
        $sec2 = $currentTime->diffInSeconds($jobStartTime, false);  // ate chegar nesse horario, para iniciar requisicoes no CN

        dd($sec1, $sec2);

        try {
            $databases = 'sadecn_new sadeio_new sadebb_new sade_config';
            $user = env('DB_USERNAME');
            $password = env('DB_PASSWORD');

            $file = storage_path(sprintf('sade_%s.sql', today('America/Sao_Paulo')->format('Ymd')));

            $process = new Process(sprintf('mysqldump -u %s -p%s --databases %s > %s', $user, $password, $databases, $file)); //realiza o dump na pasta storage da aplicação
            $process->run();

            $process = new Process(sprintf('find %s -maxdepth 1 -type f -mtime +20 | xargs rm', storage_path('*.sql'))); // busca todos os arquivos sql em storage criados a mais de 20 dias e remove-os
            $process->run();

        } catch (\Exception $e) {

            $this->error($e->getMessage());

        }

        return;
    }
}