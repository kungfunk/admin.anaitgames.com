<?php
namespace Domain\Post\Commands;

use Domain\Post\PostsRepository;
use Domain\Post\Post;

class GetLastPosts
{
    private $repository;
    private static $order_field = Post::DEFAULT_ORDER_FIELD;
    private static $order_direction = Post::DEFAULT_ORDER_DIRECTION;
    private static $limit = 10;

    public function __construct(PostsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load()
    {
        return $this->repository->getPostsPaginated(self::$order_field, self::$order_direction, self::$limit);
    }
}
