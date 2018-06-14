<?php

namespace App\Models;

class ReservaBB extends AbstractReserva
{
    protected $connection = 'mysql_bb';
    protected $table = 'reserva';

    public function licitacao()
    {
        return $this->belongsTo(LicitacaoBB::class, 'id_licitacao', 'id');
    }

    public function proxy()
    {
        return $this->morphOne(ProxyList::class, 'reserva'); //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos
    }
}