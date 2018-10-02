<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractReserva extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function getDtInicioUploadAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function getDtFimUploadAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function proxy()
    {
        return $this->morphOne(ProxyList::class, 'reserva'); //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos
    }

    abstract public function licitacao();
}
