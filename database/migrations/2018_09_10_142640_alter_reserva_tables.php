<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReservaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reserva_bb', function(Blueprint $table) {
            $table->char('nm_subtipo')->after('nm_reserva')->default('EDITAL');
            $table->char('nm_descricao')->after('nm_reserva')->default('EDITAL BB');
        });

        Schema::table('reserva_cn', function(Blueprint $table) {
            $table->char('nm_subtipo')->after('nm_reserva')->default('EDITAL');
            $table->char('nm_descricao')->after('nm_reserva')->default('EDITAL0001ed');
        });

        Schema::table('reserva_io', function(Blueprint $table) {
            $table->char('nm_subtipo')->after('nm_reserva')->default('EDITAL');
            $table->char('nm_descricao')->after('nm_reserva')->default('EDITAL005');
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
