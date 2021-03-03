<?php

namespace Modules\Article\Entities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class ArticleCategory extends Model
{
    use HasFactory, NodeTrait, SoftDeletes;

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

}
