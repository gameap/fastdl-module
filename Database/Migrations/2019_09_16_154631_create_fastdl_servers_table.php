<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFastdlServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fastdl_servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ds_id');
            $table->integer('server_id');
            $table->string('address');
            $table->boolean('remote');
            $table->timestamp('last_sync');
            $table->timestamps();

            $table->unique('ds_id', 'server_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fastdl_servers');
    }
}
