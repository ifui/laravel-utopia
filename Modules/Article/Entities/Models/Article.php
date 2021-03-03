<?php

namespace Modules\Article\Entities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

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

    /**
     * 多态一对一 对应用户表 代表作者
     *
     * @return MorphTo
     */
    public function author(): MorphTo
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
