<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewLicitacaoIoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_io')->create('licitacao', function (Blueprint $table) {
            $table->increments('id');
            $table->char('portal')->default('io');
            $table->integer('nu_licitacao');
            $table->string('nu_orgao')->nullable();
            $table->string('nm_orgao')->nullable();
            $table->string('nm_modalidade')->nullable();
            $table->text('txt_objeto')->nullable();
            $table->timestamp('dt_publicacao')->nullable();
            $table->timestamp('dt_abertura')->nullable();
            $table->string('nm_edital')->nullable();
            $table->string('nm_area')->nullable();
            $table->string('nm_subarea')->nullable();
            $table->string('nm_processo')->nullable();
            $table->string('nm_anexo_principal')->nullable();
            $table->string('nm_link_anexo')->nullable();
            $table->timestamp('dt_registro_anexo')->nullable();
            $table->timestamps();
            $table->index(['nu_licitacao', 'nu_orgao']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_io')->dropIfExists('licitacao');
    }
}
