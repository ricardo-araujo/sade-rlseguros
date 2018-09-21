<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewReservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva_cn', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_licitacao');
            $table->string('nm_reserva')->nullable();
            $table->boolean('was_uploaded')->nullable();
            $table->timestamp('dt_inicio_upload')->nullable();
            $table->timestamp('dt_fim_upload')->nullable();
            $table->timestamps();
            $table->foreign('id_licitacao')->references('id')->on('licitacao_cn');
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
