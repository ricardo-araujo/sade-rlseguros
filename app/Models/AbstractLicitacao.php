<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractLicitacao extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function getNmPregaoAttribute($value)
    {
        if (!$value)
            return null;

        $value = preg_replace('#[^\d\w\/]#', '', $value);

        while (starts_with($value, '/'))
            $value = str_replace_first('/', '', $value);

        return $value;
    }

    public function getLicitacaoRawAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function setTxtObjetoAttribute($value)
    {
        $this->attributes['txt_objeto'] = blank($value) ? null : mb_strtoupper($value);
    }

    public function setLicitacaoRawAttribute($value)
    {
        $this->attributes['licitacao_raw'] = json_encode($value);
    }

    abstract public function reserva();
}
