<?php

namespace App\Jobs;

use App\Models\AbstractReserva;
use App\Repository\ProxyListRepository;
use App\Repository\RecaptchaRepository;
use Forseti\Bot\Sade\PageObject\GetHomePageObject;
use Forseti\Bot\Sade\PageObject\GetLoginPageObject;
use Forseti\Bot\Sade\PageObject\GetReservaPageObject;
use Forseti\Bot\Sade\PageObject\PostLoginPageObject;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\HandlerStack;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use League\Pipeline\Pipeline;

class ValidaReservaCNJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AbstractReserva
     */
    private $reserva;

    /**
     * Create a new job instance.
     *
     * @param AbstractReserva|Model $reserva
     */
    public function __construct(AbstractReserva $reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RecaptchaRepository $recaptchaRepo, ProxyListRepository $proxyRepo)
    {
        $this->delete();

        if (!$token = $recaptchaRepo->token() or !$proxy = $proxyRepo->proxy()) {

            dispatch(new self($this->reserva))->onQueue('cn');

            return;
        }

        Log::debug('Validando reserva no site da Mapfre', ['reserva' => $this->reserva->toArray()]);

        /** TODO: $client */

        $parser = (new Pipeline())
            ->pipe(new GetLoginPageObject($client))
            ->pipe(new PostLoginPageObject($client, $token, env('USUARIO_MAPFRE'), env('SENHA_MAPFRE')))
            ->pipe(new GetHomePageObject($client))
            ->pipe(new GetReservaPageObject($client, $this->reserva->nm_reserva))
            ->process('');

        if ($parser)
            $this->reserva->update(['nm_viewstate' => $parser->getViewState(), 'nm_eventvalidation' => $parser->getEventValidation()]);
    }
}
