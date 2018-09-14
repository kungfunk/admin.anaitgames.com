<?php
namespace Domain\Post;

use Illuminate\Database\Eloquent\Model as Model;

class Post extends Model
{
    const ID = 'id';
    const SLUG = 'slug';

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_TRASH = 'trash';

    const DEFAULT_LIMIT = 10;
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

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

//    protected $dispatchesEvents = [
//        'created' => PostCreated::class,
//        'deleted' => PostDeleted::class,
//    ];
}