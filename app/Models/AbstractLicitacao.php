<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbstractLicitacao extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function getDtRegistroAnexoAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }
    
    public function getCreatedAtAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function setTxtObjetoAttribute($value)
    {
        $this->attributes['txt_objeto'] = blank($value) ? null : mb_strtoupper($value);
    }
}