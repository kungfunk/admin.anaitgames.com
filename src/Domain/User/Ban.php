<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;

class Ban extends Model
{
    protected $fillable = [
        'user_id',
        'banned_by_id',
        'from_date',
        'to_date',
        'reason'
    ];

    public function user()
    {
        return $this->belongsTo('Domain\Post\User');
    }

    public function by()
    {
        return $this->belongsTo('Domain\Post\User', 'banned_by_id');
    }
}
