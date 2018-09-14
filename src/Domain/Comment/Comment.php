<?php
namespace Domain\Comment;

use Illuminate\Database\Eloquent\Model as Model;

class Comment extends Model
{
    const DEFAULT_LIMIT = 10;
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

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
        return $this->belongsTo('Domain\User\User');
    }

    public function reports()
    {
        return $this->hasMany('Domain\Comment\CommentReport');
    }

    public function isReported()
    {
        return count($this->reports) > 0;
    }
}
