<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgaoIO extends Model
{
    protected $connection = 'mysql_io';
    protected $table = 'orgao';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function licitacao()
    {
        return $this->hasMany(LicitacaoIO::class, 'id_orgao', 'id');
    }
}