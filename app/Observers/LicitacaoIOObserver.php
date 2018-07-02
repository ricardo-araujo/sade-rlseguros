<?php

namespace App\Observers;

use App\Events\LicitacaoIOCreatedEvent;
use App\Models\LicitacaoIO;

class LicitacaoIOObserver
{
    public function created(LicitacaoIO $licitacao)
    {
        event(new LicitacaoIOCreatedEvent($licitacao));
    }
}
