<?php

namespace App\Jobs;

use App\Models\AbstractReserva;
use Forseti\Bot\Sade\PageObject\EditalPageObject;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\HandlerStack;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ValidaReservaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AbstractReserva
     */
    private $reserva;

    /**
     * Create a new job instance.
     *
     * @return void
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
    public function handle()
    {
        $this->delete();

        Log::debug('Buscando parametros da reserva na Mapfre', [
            'portal' => $this->reserva->licitacao->portal,
            'reserva' => $this->reserva->id
        ]);

        $client = new Client([
            'handler' => app(HandlerStack::class), //provider de Handler de retry, fiz o provider para nao poluir essa classe
            'cookies' => new FileCookieJar(default_cookie_path(), true),
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36'
            ]
        ]);

        try {

            $parser = (new EditalPageObject($client))->getCadastroArquivoDigital($this->reserva->nm_reserva);

            $this->reserva->update(['viewstate' => $parser->getViewState(), 'eventvalidation' => $parser->getEventValidation()]);

        } catch (\Exception $e) {

            Log::error('Erro ao buscar parametros da reserva', [
                'portal' => $this->reserva->licitacao->portal,
                'reserva' => $this->reserva->id,
                'exception' => $e->getMessage()
            ]);

        }
    }
}
