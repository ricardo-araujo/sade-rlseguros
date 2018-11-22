<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnLicitacaoBBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licitacao_bb', function (Blueprint $table) {
            $table->json('licitacao_raw')
                  ->nullable()
                  ->after('dt_registro_anexo')
                  ->comment('Recebida do carga p/ fins de teste');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
