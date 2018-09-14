<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;

class IpBan extends Model
{
    protected $fillable = [
        'banned_by_id',
        'from_date',
        'to_date',
        'ip',
        'reason'
    ];

    public function by()
    {
        return $this->belongsTo('Domain\Post\User', 'banned_by_id');
    }
}
