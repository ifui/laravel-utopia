<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCopyfromTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_copyfrom', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->comment('排序')->default(0);

            $table->string('title')->comment('来源');
            $table->string('description')->comment('简介')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_copyfrom');
    }
}
