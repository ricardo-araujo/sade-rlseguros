<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewLicitacaoBbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitacao_bb', function (Blueprint $table) {
            $table->increments('id');
            $table->char('portal')->default('bb');
            $table->string('nu_licitacao')->nullable();
            $table->text('txt_objeto')->nullable();
            $table->integer('nu_cliente')->nullable();
            $table->string('nm_cliente')->nullable();
            $table->integer('nu_pregoeiro')->nullable();
            $table->string('nm_pregoeiro')->nullable();
            $table->integer('nu_coordenador')->nullable();
            $table->string('nm_coordenador')->nullable();
            $table->integer('nu_presidente_comissao')->nullable();
            $table->string('nm_edital')->nullable();
            $table->string('nm_processo')->nullable();
            $table->integer('nu_modalidade')->nullable();
            $table->string('nm_tipo')->nullable();
            $table->string('nm_participacao_fornecedor')->nullable();
            $table->string('nm_prazo_impugnacao')->nullable();
            $table->integer('nu_situacao')->nullable();
            $table->string('nm_situacao')->nullable();
            $table->integer('nu_idioma')->nullable();
            $table->string('nm_idioma')->nullable();
            $table->integer('nu_abrangencia')->nullable();
            $table->string('nm_abrangencia')->nullable();
            $table->string('nm_moeda')->nullable();
            $table->string('nm_moeda_proposta')->nullable();
            $table->string('nm_fonte')->nullable();
            $table->char('nm_uf')->nullable();
            $table->timestamp('dt_publicacao')->nullable();
            $table->timestamp('dt_ini_acolhimento_proposta')->nullable();
            $table->timestamp('dt_fim_acolhimento_proposta')->nullable();
            $table->timestamp('dt_abertura_proposta')->nullable();
            $table->timestamp('dt_disputa')->nullable();
            $table->timestamp('dt_criado')->nullable();
            $table->integer('st_equalizada')->nullable();
            $table->json('nm_link_anexo')->nullable();
            $table->string('nm_anexo_principal')->nullable();
            $table->timestamp('dt_registro_anexo')->nullable();
            $table->timestamps();
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
