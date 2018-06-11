<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewOrgaoIoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_io')->create('orgao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nu_uge')->nullable();
            $table->string('nu_orgao')->nullable();
            $table->string('nm_gestao')->nullable();
            $table->string('nm_orgao')->nullable();
            $table->string('nm_endereco')->nullable();
            $table->string('nm_municipio')->nullable();
            $table->string('nm_cep')->nullable();
            $table->string('nm_email')->nullable();
            $table->string('nm_telefone_1')->nullable();
            $table->string('nm_telefone_2')->nullable();
            $table->string('nm_fax')->nullable();
            $table->string('nm_cnpj')->nullable();
            $table->timestamps();
            $table->index(['nu_uge', 'nu_orgao', 'nm_cnpj']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_io')->dropIfExists('orgao');
    }
}
