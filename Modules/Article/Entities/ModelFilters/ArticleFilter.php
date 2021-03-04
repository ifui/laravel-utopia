<?php

namespace Modules\Article\Entities\ModelFilters;

use EloquentFilter\ModelFilter;

class ArticleFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * 范围查询
     *
     * @param [type] $query
     * @return ArticleFilter
     */
    public function query($query)
    {
        return $this->where('title', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->orWhere('content', 'LIKE', "%$query%");
    }

    /**
     * 关联查询  分类
     *
     * @param [type] $query
     * @return ArticleFilter
     */
    public function category($query)
    {
        return $this->related('category', 'title', 'LIKE', "%$query%");
    }

    /**
     * 关联查询 作者
     *
     * @param [type] $author
     * @return ArticleFilter
     */
    public function author($author)
    {
        return $this->related(__FUNCTION__, function ($query) use ($author) {
            return $query->where('email', 'LIKE', "%$author%")
                ->orWhere('nickname', 'LIKE', "%$author%");
        });
    }
}
