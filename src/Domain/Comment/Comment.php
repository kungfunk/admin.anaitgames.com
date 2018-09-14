<?php
namespace Domain\Comment;

use Illuminate\Database\Eloquent\Model as Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'body',
        'formatted_body'
    ];

    public function post()
    {
        return $this->belongsTo('Domain\Post\Post');
    }

    public function user()
    {
        return $this->belongsTo('Domain\Post\User');
    }
}
