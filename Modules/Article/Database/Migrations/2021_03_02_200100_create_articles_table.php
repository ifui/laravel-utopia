<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_category_id')->comment('文章分类ID');
            $table->string('title')->comment('标题');
            $table->string('description')->comment('简介')->nullable();
            $table->text('content')->comment('内容')->nullable();
            $table->string('thumbnail')->comment('缩略图')->nullable();
            $table->tinyInteger('status')->comment('发布状态 -2: 退回 -1: 草稿 0: 审核中 1: 发布')->default(-1);
            $table->integer('order')->comment('排序')->default(0);

            $table->morphs('user');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
