<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class LicitacaoIOCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Model
     */
    public $licitacao;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $licitacao)
    {
        Log::info('Licitacao inserida no banco de dados', ['licitacao' => $licitacao->toArray()]);

        $this->licitacao = $licitacao;
    }
}
