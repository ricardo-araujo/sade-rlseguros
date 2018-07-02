<?php

namespace App\Observers;

use App\Events\LicitacaoBBCreatedEvent;
use App\Models\LicitacaoBB;

class LicitacaoBBObserver
{
    public function created(LicitacaoBB $licitacao)
    {
        event(new LicitacaoBBCreatedEvent($licitacao));
    }
}
