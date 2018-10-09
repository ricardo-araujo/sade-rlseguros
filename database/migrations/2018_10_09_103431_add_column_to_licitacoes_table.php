<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToLicitacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licitacao_bb', function (Blueprint $table) {
            $table->json('licitacao_raw')->nullable()->after('dt_registro_anexo');
        });

        Schema::table('licitacao_cn', function (Blueprint $table) {
            $table->json('licitacao_raw')->nullable()->after('dt_registro_anexo');
        });

        Schema::table('licitacao_io', function (Blueprint $table) {
            $table->json('licitacao_raw')->nullable()->after('dt_registro_anexo');
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
