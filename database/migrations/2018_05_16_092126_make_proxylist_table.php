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
            $table->string('nome')->nullable();
            $table->string('proxy')->nullable();
            $table->timestamp('used_at')->nullable()->comment('Data em que o proxy foi usado pela ultima vez');
            $table->timestamps();
            $table->softDeletes()->comment('Soft delete para caso o proxy tenha que ser invalidado');
        });
    }

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
