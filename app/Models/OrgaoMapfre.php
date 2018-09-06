<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgaoMapfre extends Model
{
    protected $table = 'orgao';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function setNmRazaoSocialAttribute($value)
    {
        $this->attributes['nm_razao_social'] = ($value) ? mb_strtoupper(trim($value)) : null;
    }

    public function setNmCnpjAttribute($value)
    {
        $this->attributes['nm_cnpj'] = ($value) ? preg_replace('#[^0-9]+#', '', $value) : null;
    }

    public function licitacaoBB()
    {
        return $this->belongsToMany(LicitacaoBB::class, 'licitacao_bb_orgao', 'id_licitacao', 'id_orgao')->using(LicitacaoBBOrgao::class);
    }

    public function licitacaoIO()
    {
        return $this->hasMany(LicitacaoIO::class, 'id_orgao');
    }
}
