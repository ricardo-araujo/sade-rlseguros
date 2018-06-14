<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgaoMapfreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_config')->create('orgao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nm_razao_social')->nullable();
            $table->string('nm_cnpj')->nullable();
            $table->string('nm_cod_mapfre')->nullable();
            $table->timestamps();
            $table->index(['nm_cnpj', 'nm_cod_mapfre']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_config')->dropIfExists('orgao_mapfre');
    }
}
