<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Builder as Query;

class Log extends Model
{
    const LEVEL_INFO = 'info';
    const LEVEL_NOTICE = 'notice';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';

    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    const ORDER_FIELD_WHITELIST = [
        'created_at',
        'level',
    ];

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'level',
        'message',
        'context',
        'extra'
    ];

    protected $casts = [
        'context' => 'array',
        'extra' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('Models\User');
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
