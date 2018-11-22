<?php

namespace App\Mail;

use App\Repository\LicitacaoBBRepository;
use App\Repository\LicitacaoCNRepository;
use App\Repository\LicitacaoIORepository;
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
        $oportunidadesBB = (new LicitacaoBBRepository())->fromDate(yesterday());
        $oportunidadesCN = (new LicitacaoCNRepository())->fromDate(today());
        $oportunidadesIO = (new LicitacaoIORepository())->fromDate(today());

        return $this->to('ricardo.araujo@forseti.com.br', 'Ricardo Araujo')
                     ->subject('[Forseti - Sade] Resumo das oportunidades do dia')
                     ->view('mail.oportunidades-do-dia', [
                         'oportunidadesBB' => $oportunidadesBB,
                         'oportunidadesCN' => $oportunidadesCN,
                         'oportunidadesIO' => $oportunidadesIO
                     ]);
    }
}
