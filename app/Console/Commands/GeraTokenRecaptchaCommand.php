<?php

namespace App\Console\Commands;

use App\Repository\RecaptchaRepository;
use App\Repository\ReservaCNRepository;
use Forseti\Crawler\NoRecaptcha\TwoCaptcha\TwoCaptchaWithGoogleKey;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GeraTokenRecaptchaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:gera-token-recaptcha {--delay= : Atrasa o command em segundos} {--f|force : Gera o token sem considerar se há oportunidades ou reservas}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera e armazena token do recaptcha do site da Mapfre';

    /**
     * @var TwoCaptchaWithGoogleKey
     */
    private $twoCaptcha;

    /**
     * @var RecaptchaRepository
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TwoCaptchaWithGoogleKey $twoCaptcha, RecaptchaRepository $repository)
    {
        parent::__construct();
        $this->twoCaptcha = $twoCaptcha;
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ReservaCNRepository $reserva)
    {
        sleep((int)$this->option('delay'));

        if ($this->option('force') || $reserva->existsToday()) //Verificacao tem como objetivo minimizar a criação de tokens em caso de dias sem reserva, para que creditos da api nao sejam gastos sem necessidade
            return $this->generateToken();

        return false;
    }

    private function generateToken()
    {
        while ($this->twoCaptcha->requisitaRespostaCaptcha()->identificaRespostaPadrao() == false)
            continue;

        $this->repository->create(['id_captcha' => $this->twoCaptcha->getIdCaptcha(), 'token' => $this->twoCaptcha->identificaRespostaPadrao()]);

        Log::debug('Token do recaptcha salvo no banco de dados', ['id_token' => $this->twoCaptcha->getIdCaptcha()]);
    }
}
