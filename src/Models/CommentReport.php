<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Model;

class CommentReport extends Model
{
    protected $fillable = [
        'comment_id',
        'user_id',
        'body',
        'checked'
    ];

    protected $casts = [
        'checked' => 'boolean',
    ];

    public function comment()
    {
        return $this->belongsTo('Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo('Models\User');
    }
}
