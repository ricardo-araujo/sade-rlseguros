<?php

namespace App\Console\Commands;

use App\Mail\OportunidadesDoDiaMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviaEmailOportunidadesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:email-oportunidades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um e-mail com as possiveis oportunidades do dia e resuma das reservas';

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
        Mail::send(new OportunidadesDoDiaMail()); //Command apenas faz uso da classe de mail, para adicionar ou alterar, entrar na respectiva classe

        return true;
    }
}
