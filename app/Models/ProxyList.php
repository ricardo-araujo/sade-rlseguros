<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProxyList extends Model
{
    use SoftDeletes;

    protected $table = 'proxylist';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function getUsedAtAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtolower($value);
    }

    public function reserva()
    {
        return $this->morphTo(); //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos
    }
}
