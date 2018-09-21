<?php

namespace App\Models;

class LicitacaoCN extends AbstractLicitacao
{
    protected $table = 'licitacao_cn';

    public function getDtAberturaPropostaAttribute($value)
    {
        if (!$value)
            return null;

        return ($value instanceof \DateTime) ? $value : new \DateTime($value);
    }

    public function getHasAnexoAttribute($value)
    {
        return (bool) $value;
    }

    public function setNmTelefoneAttribute($value)
    {
        $this->attributes['nm_telefone'] = blank($value) ? null : $value;
    }

    public function setNmFaxAttribute($value)
    {
        $this->attributes['nm_fax'] = blank($value) ? null : $value;
    }

    public function setDtEntregaPropostaAttribute($value)
    {
        $this->attributes['dt_entrega_proposta'] = (blank($value) || $value == '0000-00-00 00:00:00') ? null : $value;
    }

    public function setDtAberturaPropostaAttribute($value)
    {
        $this->attributes['dt_abertura_proposta'] = (blank($value) || $value == '0000-00-00 00:00:00') ? null : $value;
    }

    public function reserva()
    {
        return $this->hasMany(ReservaCN::class, 'id_licitacao', 'id');
    }
}
