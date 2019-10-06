<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFastdlDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fastdl_ds', function (Blueprint $table) {
            $table->integer('ds_id')->unique();
            $table->boolean('installed')->default(true);
            $table->enum('method', ['link', 'mount', 'copy', 'rsync', 'overlayfs', 'custom'])->default('rsync');
            $table->string('host');
            $table->smallInteger('port')->unsigned();
            $table->boolean('autoindex');
            $table->text('options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fastdl_ds');
    }
}
