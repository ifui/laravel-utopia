<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ArticleCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [];

}
