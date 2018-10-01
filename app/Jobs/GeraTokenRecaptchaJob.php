<?php

namespace App\Jobs;

use App\Repository\ProxyListRepository;
use App\Repository\RecaptchaRepository;
use App\Repository\ReservaBBRepository;
use App\Repository\ReservaCNRepository;
use App\Repository\ReservaIORepository;
use Forseti\Crawler\NoRecaptcha\TwoCaptcha\TwoCaptchaWithGoogleKey;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GeraTokenRecaptchaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;

    public $timeout = 180;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($delay = 0)
    {
        $this->delay((int) $delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TwoCaptchaWithGoogleKey $twoCaptcha, RecaptchaRepository $repository, ReservaBBRepository $reservasBB, ReservaCNRepository $reservasCN, ReservaIORepository $reservasIO, ProxyListRepository $proxies)
    {
        $this->delete();

        if ($reservasBB->wasUploaded() && $reservasCN->wasUploaded() && $reservasIO->wasUploaded() && $proxies->logged())
            return; //Verificacao tem como objetivo minimizar a criação de tokens em caso de dias sem reserva, para que creditos da api nao sejam gastos sem necessidade

        while ($twoCaptcha->requisitaRespostaCaptcha()->identificaRespostaPadrao() == false)
            continue;

        Log::debug('Token do recaptcha salvo no banco de dados', ['id_token' => $twoCaptcha->getIdCaptcha()]);

        $repository->create(['id_captcha' => $twoCaptcha->getIdCaptcha(), 'token' => $twoCaptcha->identificaRespostaPadrao()]);
    }
}
