<?php

namespace App\Models;

class ReservaBB extends AbstractReserva
{
    protected $table = 'reserva_bb';

    public function licitacao()
    {
        return $this->belongsTo(LicitacaoBB::class, 'id_licitacao', 'id');
    }
}
