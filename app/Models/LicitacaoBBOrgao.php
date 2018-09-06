<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LicitacaoBBOrgao extends Pivot //tabela pivot para relacionamento de orgaos da mapfre e licitacoes
{
    protected $table = 'licitacao_bb_orgao';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;
}
