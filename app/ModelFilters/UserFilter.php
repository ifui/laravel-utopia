<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
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
        return $this->where('nickname', 'LIKE', "%$query%")
            ->orWhere('id', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%");
    }

    public function id($query)
    {
        return $this->where(__FUNCTION__, $query);
    }

    public function nickname($query)
    {
        return $this->where(__FUNCTION__, 'LIKE', "%$query%");
    }

    public function email($query)
    {
        return $this->where(__FUNCTION__, 'LIKE', "%$query%");
    }
}
