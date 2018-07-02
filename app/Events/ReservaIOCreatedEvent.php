<?php

namespace App\Events;

use App\Models\ReservaIO;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReservaIOCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ReservaIO
     */
    public $reserva;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ReservaIO $reserva)
    {
        $this->reserva = $reserva;
    }
}
