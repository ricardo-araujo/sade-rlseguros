<?php

namespace App\Notifications;

use App\Models\AbstractLicitacao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class LicitacaoCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var AbstractLicitacao
     */
    private $licitacao;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(AbstractLicitacao $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $portal = $this->getPortal($this->licitacao->portal);
        $checkMarkEmoji = "\xE2\x9C\x85";

        return TelegramMessage::create()
                               ->to('-273987674')
                               ->content("*NOVA OPORTUNIDADE* {$checkMarkEmoji} \n*Portal*: {$portal}\n*Objeto*: _{$this->licitacao->txt_objeto}_");
    }

    private function getPortal($portal)
    {
        switch ($portal) {
            case 'bb':
                return '[Banco do Brasil](http://www.licitacoes-e.com.br/)';
            case 'cn':
                return '[ComprasNet](http://www.comprasgovernamentais.gov.br/)';
            case 'io':
                return '[Imprensa Oficial](http://www.imprensaoficial.com.br/)';
        }
    }
}
