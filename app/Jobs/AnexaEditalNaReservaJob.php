<?php

namespace App\Jobs;

use App\Models\AbstractReserva;
use App\Repository\RecaptchaRepository;
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

        if (!$token = $recaptchaRepo->token()) {

            dispatch(new self($this->reserva))->onQueue($this->reserva->licitacao->portal);

            return;
        }

        Log::info('Tentando enviar edital para a reserva na Mapfre', ['reserva' => $this->reserva->toArray()]);

        $this->reserva->update(['dt_inicio_upload' => now()]);

        try {

            $html = '';

            $this->reserva->update(['was_uploaded' => check_upload($html)]);

        } catch (\Exception $e) {

            Log::error('Erro ao tentar enviar edital para reserva', ['reserva' => $this->reserva->toArray(), 'exception' => $e]);

        }

        $this->reserva->update(['dt_fim_upload' => now()]);
    }
}
