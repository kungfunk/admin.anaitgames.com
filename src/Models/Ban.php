<?php
namespace Models;

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
        return $this->belongsTo('Models\User');
    }

    public function bannedBy()
    {
        return $this->belongsTo('Models\User', 'banned_by_id');
    }
}
