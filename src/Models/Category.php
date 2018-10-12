<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Model;

class Category extends Model
{
    public function posts()
    {
        return $this->hasMany('Models\Post');
    }
}
