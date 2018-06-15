<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrgaoForeignKeyToLicitacaoIO extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_io')->table('licitacao', function(Blueprint $table) {
            $table->unsignedInteger('id_orgao')->nullable()->after('id');
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
    }
}
