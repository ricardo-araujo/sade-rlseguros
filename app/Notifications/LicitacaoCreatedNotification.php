<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class LicitacaoCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Model
     */
    private $licitacao;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Model $licitacao)
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
        $chatID = env('TELEGRAM_CHAT_ID');

        return TelegramMessage::create()
                               ->to($chatID)
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

            default:
                return false;

        }
    }
}
