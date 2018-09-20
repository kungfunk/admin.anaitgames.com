<?php
namespace Domain\Post;

use Illuminate\Database\Eloquent\Model as Model;

class Category extends Model
{
    public function posts()
    {
        return $this->hasMany('Domain\Post\Post');
    }
}
