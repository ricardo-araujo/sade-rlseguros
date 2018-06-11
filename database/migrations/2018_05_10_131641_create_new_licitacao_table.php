<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewLicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_cn')->create('licitacao', function (Blueprint $table) {
            $table->increments('id');
            $table->char('portal')->default('cn');
            $table->string('nm_uf')->nullable();
            $table->string('nm_orgao')->nullable();
            $table->integer('nu_uasg')->nullable();
            $table->integer('nu_pregao')->nullable();
            $table->string('nm_endereco')->nullable();
            $table->string('nm_telefone')->nullable();
            $table->string('nm_fax')->nullable();
            $table->text('txt_objeto')->nullable();
            $table->tinyInteger('nu_modalidade')->nullable();
            $table->string('nm_modalidade')->nullable();
            $table->timestamp('dt_entrega_proposta')->nullable();
            $table->timestamp('dt_abertura_proposta')->nullable();
            $table->boolean('has_anexo')->default(false);
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
        $database = Schema::connection('mysql_cn');

        $database->disableForeignKeyConstraints();

        $database->dropIfExists('licitacao');
    }
}
