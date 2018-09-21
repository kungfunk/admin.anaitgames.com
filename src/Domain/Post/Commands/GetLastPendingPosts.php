<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\PostsRepository;
use Domain\Post\Post;
use Carbon\Carbon;

class GetLastPendingPosts implements CommandInterface
{
    private $postsRepository;
    private static $order_field = Post::DEFAULT_ORDER_FIELD;
    private static $order_direction = Post::DEFAULT_ORDER_DIRECTION;
    private static $limit = 10;

    public function __construct(PostsRepository $postRepository)
    {
        $this->postsRepository = $postRepository;
    }

    public function run()
    {
        $this->postsRepository->newQuery();

        $this->postsRepository->setOrderAndPagination(
            self::$order_field,
            self::$order_direction,
            self::$limit
        );

        $this->postsRepository->setFilters(
            null,
            null,
            null,
            Post::STATUS_PUBLISHED
        );

        $this->postsRepository->setPublishDateMoreThan(Carbon::now());

        return $this->postsRepository->get();
    }
}
