<?php

namespace App\Models;

class LicitacaoBB extends AbstractLicitacao
{
    protected $table = 'licitacao_bb';
    protected $dates = ['dt_publicacao', 'dt_ini_acolhimento_proposta', 'dt_fim_acolhimento_proposta', 'dt_abertura_proposta', 'dt_disputa', 'dt_criado', 'dt_registro_anexo'];

    public function getNmLinkAnexoAttribute($value)
    {
        return json_decode($value, true);
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
        $this->attributes['dt_disputa'] = (blank($value) || $value == '0000-00-00 00:00:00') ? null : $value;
    }

    public function setNmLinkAnexoAttribute($value)
    {
        $this->attributes['nm_link_anexo'] = (filled($value)) ? json_encode($value) : null;
    }

    public function reserva()
    {
        return $this->hasMany(ReservaBB::class, 'id_licitacao', 'id');
    }

    public function orgao()
    {
        return $this->belongsToMany(OrgaoMapfre::class, 'licitacao_bb_orgao', 'id_licitacao', 'id_orgao')->using(LicitacaoBBOrgao::class);
    }
}
