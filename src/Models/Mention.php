<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Model;

class Mention extends Model
{
    protected $fillable = [
        'user_from_id',
        'user_to_id',
        'comment_id',
        'checked'
    ];

    public function comment()
    {
        return $this->belongsTo('Models\Comment');
    }

    public function from()
    {
        return $this->belongsTo('Models\User', 'user_from_id');
    }

    public function to()
    {
        return $this->belongsTo('Models\User', 'user_to_id');
    }
}
