<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LicitacaoBBOrgao extends Pivot //tabela pivot para relacionamento de orgaos da mapfre e licitacoes
{
    public $timestamps = false;
    protected $connection = 'mysql_bb';
    protected $table = 'licitacao_orgao';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}