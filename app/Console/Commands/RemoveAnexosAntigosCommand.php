<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RemoveAnexosAntigosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:remove-anexos {--days=30 : Busca anexos com data de criação maior ou igual ao informado}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca anexos de bb, cn e io e remove-os. Caso não informe a quantidade de dias, remove arquivos criados há mais de um mês.';

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
        $days = (int) $this->option('days');

        if ($days <= 0) //para manter anexos do dia atual
            $days = 1;

        $path = public_path('anexos' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*');

        $process = new Process(sprintf("find %s -maxdepth 2 -type d -mtime +$days | xargs rm -rf", $path));
        $process->run();

        return;
    }
}
