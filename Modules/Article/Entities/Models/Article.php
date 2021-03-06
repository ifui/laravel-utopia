<?php

namespace Modules\Article\Entities\Models;

use Cviebrock\EloquentTaggable\Taggable; // 标签
use EloquentFilter\Filterable; //  模型筛选
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Article\Entities\ModelFilters\ArticleFilter;

class Article extends Model
{
    use HasFactory, SoftDeletes, Filterable, Taggable;

    protected $fillable = [
        'title',
        'article_category_id',
        'description',
        'content',
        'thumbnail',
        'status',
        'order',
    ];

    protected $hidden = [
        'user_id',
        'user_type',
        'article_category_id',
    ];

    protected $with = [
        'user:id,email,nickname',
        'category',
        'tags',
    ];

    /**
     * 重写模型筛选目录路径
     *
     * @return string
     */
    public function provideFilter()
    {
        return ArticleFilter::class;
    }

    /**
     * 多态一对一 对应用户表 代表作者
     *
     * @return MorphTo
     */
    public function user(): MorphTo
    {
        return $this->morphTo('user');
    }

    /**
     * 关联一对一 代表分类
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id', 'id');
    }

}
