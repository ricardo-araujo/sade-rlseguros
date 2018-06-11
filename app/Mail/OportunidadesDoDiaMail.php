<?php

namespace App\Mail;

use App\Repository\LicitacaoCNRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OportunidadesDoDiaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $oportunidades = (new LicitacaoCNRepository())->fromDate(new \DateTime());

        return $this->to('ricardo.araujo@forseti.com.br', 'Ricardo Araujo')
                     ->subject('[Forseti - Sade CN] Resumo das oportunidades do dia')
                     ->view('mail.oportunidades-do-dia', ['oportunidades' => $oportunidades]);
    }
}
