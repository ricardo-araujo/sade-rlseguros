<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeProxylistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_config')->create('proxylist', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reserva_id')->nullable(); #
            $table->char('reserva_type')->nullable()->comment('Portal da reserva'); #
            $table->string('nome')->nullable();
            $table->string('proxy')->nullable();
            $table->timestamp('used_at')->nullable()->comment('Data em que o proxy foi usado pela ultima vez');
            $table->timestamps();
            $table->softDeletes()->comment('Soft delete para caso o proxy tenha que ser invalidado');
            $table->index(['reserva_id', 'reserva_type']); #
        });
    } #Simulacao do metodo '$table->nullableMorphs()'. //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos)

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_config')->dropIfExists('proxylist');
    }
}
