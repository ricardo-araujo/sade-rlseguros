<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recaptcha extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql_config';
    protected $table = 'recaptcha';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
