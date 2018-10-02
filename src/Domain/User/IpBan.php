<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;

class IpBan extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'banned_by_id',
        'expires',
        'ip',
        'reason'
    ];

    public function bannedBy()
    {
        return $this->belongsTo('Domain\Post\User', 'banned_by_id');
    }
}
