<?php

namespace App\Observers;

use App\Events\LicitacaoCNCreatedEvent;
use App\Models\LicitacaoCN;

class LicitacaoCNObserver
{
    public function created(LicitacaoCN $licitacao)
    {
        event(new LicitacaoCNCreatedEvent($licitacao));
    }
}
