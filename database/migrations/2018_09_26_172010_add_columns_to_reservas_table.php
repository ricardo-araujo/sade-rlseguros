<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reserva_bb', function (Blueprint $table) {
            $table->text('eventvalidation')->nullable()->after('dt_fim_upload');
            $table->text('viewstate')->nullable()->after('dt_fim_upload');
        });

        Schema::table('reserva_cn', function (Blueprint $table) {
            $table->text('eventvalidation')->nullable()->after('dt_fim_upload');
            $table->text('viewstate')->nullable()->after('dt_fim_upload');
        });

        Schema::table('reserva_io', function (Blueprint $table) {
            $table->text('eventvalidation')->nullable()->after('dt_fim_upload');
            $table->text('viewstate')->nullable()->after('dt_fim_upload');
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
