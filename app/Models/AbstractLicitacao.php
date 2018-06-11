<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractLicitacao extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function getCreatedAtAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    abstract public function reserva();
}