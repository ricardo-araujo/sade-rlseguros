<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class LicitacaoCNCreatedEvent
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
        Log::info('Licitacao inserida no banco de dados', ['portal' => $licitacao->portal, 'licitacao' => $licitacao->id]);

        $this->licitacao = $licitacao;
    }
}
