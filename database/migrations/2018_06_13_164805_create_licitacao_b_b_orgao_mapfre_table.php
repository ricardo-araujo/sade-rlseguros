<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicitacaoBBOrgaoMapfreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_bb')->create('licitacao_orgao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_licitacao')->nullable();
            $table->unsignedInteger('id_orgao')->nullable();
            $table->foreign('id_licitacao')->references('id')->on('licitacao');
            $table->foreign('id_orgao')->references('id')->on('sade_config.orgao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_bb')->dropIfExists('licitacao_orgao');
    }
}
