<?php

namespace App\Models;

class ReservaCN extends AbstractReserva
{
    protected $table = 'reserva_cn';

    public function licitacao()
    {
        return $this->belongsTo(LicitacaoCN::class, 'id_licitacao', 'id');
    }
}
