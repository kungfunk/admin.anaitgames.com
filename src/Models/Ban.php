<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Builder as Query;

class Ban extends Model
{
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    const ORDER_FIELD_WHITELIST = [
        'created_at',
        'expires',
        'reason'
    ];

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

    public function scopeFilters(Query $query, array $filters)
    {
        foreach ($filters as $name => $value) {
            if (!empty($value)) {
                $query->where($name, $value);
            }
        }

        return $query;
    }
}
