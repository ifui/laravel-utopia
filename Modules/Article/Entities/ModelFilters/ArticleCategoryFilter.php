<?php

namespace Modules\Article\Entities\ModelFilters;

use EloquentFilter\ModelFilter;

class ArticleCategoryFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function query($query)
    {
        return $this->where('title', 'LIKE', "%$query%");
    }
}
