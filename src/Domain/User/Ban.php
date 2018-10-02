<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;

class Ban extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'banned_by_id',
        'expires',
        'reason'
    ];

    public function user()
    {
        return $this->belongsTo('Domain\Post\User');
    }

    public function bannedBy()
    {
        return $this->belongsTo('Domain\Post\User', 'banned_by_id');
    }
}
