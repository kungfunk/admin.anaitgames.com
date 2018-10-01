<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;

class Log extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'level',
        'message',
        'context',
        'extra'
    ];

    public function user()
    {
        return $this->belongsTo('Domain\User\User');
    }
}
