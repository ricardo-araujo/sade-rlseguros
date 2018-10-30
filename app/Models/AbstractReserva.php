<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractReserva extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['dt_inicio_upload', 'dt_fim_upload'];

    public function proxy()
    {
        return $this->morphOne(ProxyList::class, 'reserva'); //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos
    }

    abstract public function licitacao();
}
