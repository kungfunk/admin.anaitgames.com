<?php
namespace Domain\Post;

use Illuminate\Database\Eloquent\Model as Model;

class Tag extends Model
{
    const JUNCTION_TABLE_NAME = 'posts_tags';

    protected $fillable = [
        'name',
        'slug',
    ];

    public $timestamps = false;
}
