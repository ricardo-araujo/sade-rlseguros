<?php

namespace App\Listeners;

use App\Events\LicitacaoCreatedEvent;
use App\Notifications\LicitacaoCreatedNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLicitacaoTelegramListener
{
    use Notifiable;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(LicitacaoCreatedEvent $event)
    {
        $this->notify(new LicitacaoCreatedNotification($event->licitacao));
    }
}
