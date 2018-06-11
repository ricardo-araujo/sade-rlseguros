<?php

namespace App\Models;

class ReservaIO extends AbstractReserva
{
    protected $connection = 'mysql_io';
    protected $table = 'reserva';

    public function licitacao()
    {
        return $this->belongsTo(LicitacaoIO::class, 'id_licitacao', 'id');
    }
}