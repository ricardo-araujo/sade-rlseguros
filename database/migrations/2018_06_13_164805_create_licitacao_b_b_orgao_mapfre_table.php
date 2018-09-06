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
        Schema::create('licitacao_bb_orgao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_licitacao')->nullable();
            $table->unsignedInteger('id_orgao')->nullable();
            $table->foreign('id_licitacao')->references('id')->on('licitacao_bb');
            $table->foreign('id_orgao')->references('id')->on('orgao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
