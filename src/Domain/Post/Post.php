<?php
namespace Domain\Post;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Builder as Query;

class Post extends Model
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_TRASH = 'trash';

    const STATUS_DRAFT_NAME = 'Borrador';
    const STATUS_PUBLISHED_NAME = 'Publicado';
    const STATUS_TRASH_NAME = 'Papelera';

    const DEFAULT_LIMIT = 10;
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    const ORDER_FIELD_WHITELIST = [
        'created_at',
        'publish_date',
        'title',
        'num_views'
    ];

    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'publish_date',
        'title',
        'subtitle',
        'slug',
        'body',
        'formatted_body',
        'excerpt',
        'original_author',
        'score',
        'num_views',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany('Domain\Comment\Comment');
    }

    public function user()
    {
        return $this->belongsTo('Domain\User\User');
    }

    public function category()
    {
        return $this->belongsTo('Domain\Post\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('Domain\Post\Tag', Tag::JUNCTION_TABLE_NAME);
    }

    public function getStatusName()
    {
        switch ($this->status) {
            case self::STATUS_DRAFT:
                $statusName = self::STATUS_DRAFT_NAME;
                break;
            case self::STATUS_PUBLISHED:
                $statusName = self::STATUS_PUBLISHED_NAME;
                break;
            case self::STATUS_TRASH:
                $statusName = self::STATUS_TRASH_NAME;
                break;
            default:
                $statusName = null;
                break;
        }

        return $statusName;
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
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
        }

        return $query;
    }

//    protected $dispatchesEvents = [
//        'created' => PostCreated::class,
//        'deleted' => PostDeleted::class,
//    ];
}
