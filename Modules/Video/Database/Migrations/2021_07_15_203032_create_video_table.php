<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video', function (Blueprint $table) {
            $table->id();
            $table->integer('video_category_id')->comment('分类');
            $table->integer('video_copyfrom_id')->comment('来源');
            $table->integer('video_series_id')->comment('所属系列')->nullable();

            $table->integer('order')->comment('排序')->default(0);

            $table->string('title')->comment('视频标题');
            $table->string('description')->comment('视频简介')->nullable();
            $table->time('time')->comment('时长');

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
        Schema::dropIfExists('video');
    }
}
