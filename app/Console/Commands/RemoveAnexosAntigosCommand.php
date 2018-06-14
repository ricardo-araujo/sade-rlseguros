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
    protected $signature = 'sade:remove-anexos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca no diretorio public/anexos, dentro de bb, cn e io, diretórios criados há mais de quatro meses e remove-os';

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
        $path = public_path('anexos' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*');

        $process = new Process(sprintf('find %s -maxdepth 2 -type d -mtime +120 | xargs rm -rf', $path));
        $process->run();

        return;
    }
}
