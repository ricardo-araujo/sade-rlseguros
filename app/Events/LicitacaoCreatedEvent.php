<?php

namespace App\Events;

use App\Models\AbstractLicitacao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LicitacaoCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var AbstractLicitacao
     */
    public $licitacao;

    /**
     * Create a new event instance.
     *
     * @param AbstractLicitacao|Model $licitacao
     *
     * @return void
     */
    public function __construct(AbstractLicitacao $licitacao)
    {
        $this->licitacao = $licitacao;
    }
}
