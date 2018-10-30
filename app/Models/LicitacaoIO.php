<?php

namespace App\Models;

class LicitacaoIO extends AbstractLicitacao
{
    protected $table = 'licitacao_io';
    protected $dates = ['dt_publicacao', 'dt_disputa', 'dt_registro_anexo'];

    public function setNmOrgaoAttribute($value)
    {
        $this->attributes['nm_orgao'] = mb_strtoupper($value);
    }

    public function reserva()
    {
        return $this->hasMany(ReservaIO::class, 'id_licitacao', 'id');
    }

    public function orgao()
    {
        return $this->belongsTo(OrgaoMapfre::class, 'id_orgao');
    }
}
