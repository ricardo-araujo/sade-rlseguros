<?php

namespace App\Models;

class LicitacaoBB extends AbstractLicitacao
{
    protected $connection = 'mysql_bb';
    protected $table = 'licitacao';

    public function getDtPublicacaoAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function getDtAberturaPropostaAttribute($value)
    {
        return ($value) ? new \DateTime($value) : null;
    }

    public function getNmLinkAnexoAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setTxtObjetoAttribute($value)
    {
        $this->attributes['txt_objeto'] = mb_strtoupper($value);
    }

    public function setNuPregoeiroAttribute($value)
    {
        $this->attributes['nu_pregoeiro'] = (filled($value)) ? $value : null;
    }

    public function setNmPregoeiroAttribute($value)
    {
        $this->attributes['nm_pregoeiro'] = (filled($value)) ? $value : null;
    }

    public function setNuPresidenteComissaoAttribute($value)
    {
        $this->attributes['nu_presidente_comissao'] = (filled($value)) ? $value : null;
    }

    public function setDtDisputaAttribute($value)
    {
        $this->attributes['dt_disputa'] = ($value == '0000-00-00 00:00:00') ? null : $value;
    }

    public function setNmLinkAnexoAttribute($value)
    {
        $this->attributes['nm_link_anexo'] = (filled($value)) ? json_encode($value) : null;
    }

    public function reserva()
    {
        return $this->hasMany(ReservaBB::class, 'id_licitacao', 'id');
    }
}
