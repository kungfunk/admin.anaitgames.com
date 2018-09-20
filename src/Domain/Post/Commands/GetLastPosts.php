<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\PostsRepository;
use Domain\Post\Post;

class GetLastPosts implements CommandInterface
{
    private $postsRepository;
    private static $order_field = Post::DEFAULT_ORDER_FIELD;
    private static $order_direction = Post::DEFAULT_ORDER_DIRECTION;
    private static $limit = 10;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function run()
    {
        return $this->postsRepository->getPostsPaginated(
            self::$order_field,
            self::$order_direction,
            self::$limit
        );
    }
}
