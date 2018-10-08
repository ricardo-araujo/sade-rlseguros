<?php

namespace App\Jobs;

use App\Models\AbstractReserva;
use App\Repository\RecaptchaRepository;
use Forseti\Bot\Sade\PageObject\EditalPageObject;
use Forseti\Bot\Sade\Pipeline\PostEditalPipeline;
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

class AnexaEditalNaReservaJob implements ShouldQueue
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
    public function handle(RecaptchaRepository $recaptchaRepo)
    {
        $this->delete();

        if (!$this->reserva->proxy or !$token = $recaptchaRepo->token()) {

            dispatch(new self($this->reserva))->onQueue($this->reserva->licitacao->portal);

            return;
        }

        Log::info('Tentando enviar edital para a reserva na Mapfre', [
            'portal' => $this->reserva->licitacao->portal ,
            'licitacao' => $this->reserva->licitacao->id ,
            'reserva' => $this->reserva->id
        ]);

        $this->reserva->update(['dt_inicio_upload' => now()]);

        $client = new Client([
            'handler' => app(HandlerStack::class), //provider de Handler de retry, fiz o provider para nao poluir essa classe
            'proxy' => $this->reserva->proxy->proxy,
            'cookies' => new FileCookieJar(storage_path("{$this->reserva->proxy->nome}.txt"), true),
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36'
            ]
        ]);

        try {

            $parser = (new EditalPageObject($client))->postCadastroArquivoDigital(
                $token,
                $this->reserva->nm_reserva,
                $this->reserva->nm_subtipo,
                $this->reserva->nm_descricao,
                edital_path($this->reserva->licitacao),
                $this->reserva->viewstate,
                $this->reserva->eventvalidation
            );

            $html = $parser->getHtml();

            if (wrong_recaptcha_token($html)) {

                dispatch(new self($this->reserva))->onQueue($this->reserva->licitacao->portal);

                return;
            }

            $this->reserva->update(['was_uploaded' => check_upload($html)]);

        } catch (\Exception $e) {

            Log::error('Erro ao tentar enviar edital para reserva', [
                'portal' => $this->reserva->licitacao->portal ,
                'licitacao' => $this->reserva->licitacao->id ,
                'reserva' => $this->reserva->id,
                'exception' => $e
            ]);

        }

        $this->reserva->proxy->reserva()->dissociate()->save(); // retira proxy da reserva, p/ ser usado novamente

        $this->reserva->update(['dt_fim_upload' => now()]);

        file_put_contents("/tmp/sade_{$this->reserva->nm_reserva}.html", $html);
    }
}
