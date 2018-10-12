<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Builder as Query;

use Carbon\Carbon;

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

    public function scopeActive(Query $query)
    {
        return $query->where('expires', '>', Carbon::now());
    }
}
