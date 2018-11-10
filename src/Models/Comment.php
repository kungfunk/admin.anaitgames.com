<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Builder as Query;

class Comment extends Model
{
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    const ORDER_FIELD_WHITELIST = [
        'created_at',
        'body'
    ];

    protected $fillable = [
        'post_id',
        'user_id',
        'body',
        'formatted_body'
    ];

    public function post()
    {
        return $this->belongsTo('Models\Post');
    }

    public function user()
    {
        return $this->belongsTo('Models\User');
    }

    public function reports()
    {
        return $this->hasMany('Models\CommentReport');
    }

    public function isReported(): bool
    {
        return count($this->reports) > 0;
    }

    public function isEdited(): bool
    {
        if ($this->updated_at != null) {
            return $this->updated_at->gt($this->created_at);
        }

        return false;
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

    public function scopeSearch(Query $query, $search)
    {
        if (!empty($search)) {
            $query->where('body', 'like', "%{$search}%");
        }

        return $query;
    }
}
