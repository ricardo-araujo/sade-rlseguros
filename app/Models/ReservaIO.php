<?php

namespace App\Models;

class ReservaIO extends AbstractReserva
{
    protected $table = 'reserva_io';

    public function licitacao()
    {
        return $this->belongsTo(LicitacaoIO::class, 'id_licitacao', 'id');
    }
}
