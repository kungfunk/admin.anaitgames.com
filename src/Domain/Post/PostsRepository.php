<?php
namespace Domain\Post;

use Carbon\Carbon;

class PostsRepository
{
    private $post_model;

    public function __construct(Post $post)
    {
        $this->post_model = $post;
    }

    private function addRelationShips($query)
    {
        return $query
            ->withCount('comments')
            ->with('category')
            ->with('user')
            ->with('tags');
    }

    private function addOrder($query, $order_field, $order_direction, $limit, $offset)
    {
        return $query
            ->orderBy($order_field, $order_direction)
            ->offset($offset)
            ->limit($limit);
    }

    public function getPostById($id)
    {
        return $this->post_model->find($id);
    }

    public function getDraftPostsPaginated(
        string $order_field = Post::DEFAULT_ORDER_FIELD,
        string $order_direction = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $query = $this->post_model
            ->where('status', Post::STATUS_DRAFT);

        $query = $this->addRelationShips($query);
        $query = $this->addOrder($query, $order_field, $order_direction, $limit, $offset);

        return $query->get();
    }

    public function getNotPublishedPostsPaginated(
        string $order_field = Post::DEFAULT_ORDER_FIELD,
        string $order_direction = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {

        $query = $this->post_model
            ->where('status', Post::STATUS_PUBLISHED)
            ->where('publish_date', '>', Carbon::now()->toDateTimeString());

        $query = $this->addRelationShips($query);
        $query = $this->addOrder($query, $order_field, $order_direction, $limit, $offset);

        return $query->get();
    }

    public function getPostsPaginated(
        string $order_field = Post::DEFAULT_ORDER_FIELD,
        string $order_direction = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $query = $this->post_model;
        $query = $this->addRelationShips($query);
        $query = $this->addOrder($query, $order_field, $order_direction, $limit, $offset);

        return $query->get();
    }

//    public function getPostsPaginated($options)
//    {
//        // TODO: add type and tags to the filters
//        $query = $this->post_model->query();
//
//        if (!is_null($options['search'])) {
//            $query = $query->where(
//                Post::SEARCHABLE_FIELD,
//                'like',
//                '%' . $options['search'] . '%'
//            );
//        }
//
//        if (!is_null($options['slug'])) {
//            $query = $query->where(Post::SLUG, $options['slug']);
//        }
//
//        return $query
//            ->where('status', $options['status'])
//            ->withCount('comments')
//            ->with('category')
//            ->with('user')
//            ->with('tags')
//            ->orderBy($options['order_by'], $options['order'])
//            ->offset($options['offset'])
//            ->limit($options['limit'])
//            ->get();
//    }
}
