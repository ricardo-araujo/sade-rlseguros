<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractReserva extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    abstract public function licitacao();
}