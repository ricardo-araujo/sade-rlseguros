<?php

namespace App\Models;

class ReservaIO extends AbstractReserva
{
    protected $table = 'reserva_io';

    public function licitacao()
    {
        return $this->belongsTo(LicitacaoIO::class, 'id_licitacao', 'id');
    }

    public function proxy()
    {
        return $this->morphOne(ProxyList::class, 'reserva'); //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos
    }
}
