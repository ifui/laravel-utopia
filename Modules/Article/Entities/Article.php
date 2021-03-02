<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'thumbnail',
        'status',
        'author_id',
        'author_type',
    ];
}
