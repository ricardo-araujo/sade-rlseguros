<?php

namespace App\Events;

use App\Models\ReservaBB;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class ReservaBBCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ReservaBB
     */
    public $reserva;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ReservaBB $reserva)
    {
        Log::info('Reserva inserida no banco de dados', ['reserva' => $reserva->id, 'licitacao' => $reserva->licitacao->id]);

        $this->reserva = $reserva;
    }
}
