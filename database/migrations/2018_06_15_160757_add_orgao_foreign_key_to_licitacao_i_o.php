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
        Schema::table('licitacao_io', function(Blueprint $table) {
            $table->unsignedInteger('id_orgao')->nullable()->after('id');
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
