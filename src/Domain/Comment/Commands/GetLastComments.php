<?php
namespace Domain\Comment\Commands;

use Domain\Comment\CommentsRepository;
use Domain\Comment\Comment;

class GetLastComments
{
    private $repository;
    private static $order_field = Comment::DEFAULT_ORDER_FIELD;
    private static $order_direction = Comment::DEFAULT_ORDER_DIRECTION;
    private static $limit = 12;

    public function __construct(CommentsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load()
    {
        return $this->repository->getCommentsPaginated(
            self::$order_field,
            self::$order_direction,
            self::$limit
        );
    }
}
