<?php

namespace App\Models;

class LicitacaoIO extends AbstractLicitacao
{
    protected $connection = 'mysql_io';
    protected $table = 'licitacao';

    public function setNmOrgaoAttribute($value)
    {
        $this->attributes['nm_orgao'] = mb_strtoupper($value);
    }

    public function getDtPublicacaoAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function getDtAberturaAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function orgao()
    {
        return $this->belongsTo(OrgaoIO::class, 'id_orgao', 'id');
    }

    public function reserva()
    {
        return $this->hasMany(ReservaIO::class, 'id_licitacao', 'id');
    }
}