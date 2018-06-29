<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class LicitacaoCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Model
     */
    public $licitacao;

    /**
     * Create a new event instance.
     *
     * @param Model $licitacao
     *
     * @return void
     */
    public function __construct(Model $licitacao)
    {
        Log::info('Licitacao inserida no banco de dados', ['licitacao' => $licitacao->toArray()]);

        $this->licitacao = $licitacao;
    }
}
