<?php

namespace Modules\Article\Entities\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; //  模型筛选
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Article\Entities\ModelFilters\ArticleCategoryFilter;

class ArticleCategory extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, Filterable;

    protected $fillable = [
        'title',
        'icon',
        'parent_id',
    ];

    protected $hidden = [
        '_lft',
        '_rgt',
        'deleted_at',
    ];

    /**
     * 重写模型筛选目录路径
     *
     * @return string
     */
    public function provideFilter()
    {
        return ArticleCategoryFilter::class;
    }

}
