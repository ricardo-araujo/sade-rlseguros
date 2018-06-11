<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewReservaBbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_bb')->create('reserva', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_licitacao')->nullable();
            $table->string('nm_reserva')->nullable();
            $table->text('nm_viewstate')->nullable();
            $table->text('nm_eventvalidation')->nullable();
            $table->boolean('was_uploaded')->nullable();
            $table->timestamp('dt_inicio_upload')->nullable();
            $table->timestamp('dt_fim_upload')->nullable();
            $table->timestamps();
            $table->foreign('id_licitacao')->references('id')->on('licitacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_bb')->dropIfExists('reserva');
    }
}
