<?php

namespace Modules\Article\Entities\Models;

use Cviebrock\EloquentTaggable\Models\Tag;
use EloquentFilter\Filterable;
use Modules\Article\Entities\ModelFilters\TagFilter;

class TaggableTag extends Tag
{
    use Filterable;

    protected $hidden = ['pivot'];

    protected $fillable = ['name', 'normalized'];

    /**
     * 重写模型筛选目录路径
     *
     * @return string
     */
    public function provideFilter()
    {
        return TagFilter::class;
    }
}
