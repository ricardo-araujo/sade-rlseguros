<?php

namespace App\Models;

class ReservaCN extends AbstractReserva
{
    protected $connection = 'mysql_cn';
    protected $table = 'reserva';

    public function getDtInicioUploadAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function getDtFimUploadAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function licitacao()
    {
        return $this->belongsTo(LicitacaoCN::class, 'id_licitacao', 'id');
    }

    public function proxy()
    {
        return $this->morphOne(ProxyList::class, 'reserva'); //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos
    }
}
