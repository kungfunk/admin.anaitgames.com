<?php
namespace Domain\Comment;

use Illuminate\Database\Eloquent\Model as Model;

class CommentReport extends Model
{
    protected $fillable = [
        'comment_id',
        'user_id',
        'body',
        'checked'
    ];

    public function comment()
    {
        return $this->belongsTo('Domain\Comment\Comment');
    }

    public function user()
    {
        return $this->belongsTo('Domain\Comment\User');
    }
}
