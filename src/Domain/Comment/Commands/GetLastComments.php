<?php
namespace Domain\Comment\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\Comment\CommentsRepository;
use Domain\Comment\Comment;

class GetLastComments implements CommandInterface
{
    private $commentsRepository;
    private static $order_field = Comment::DEFAULT_ORDER_FIELD;
    private static $order_direction = Comment::DEFAULT_ORDER_DIRECTION;
    private static $limit = 12;

    public function __construct()
    {
        $this->commentsRepository = new CommentsRepository;
    }

    public function run()
    {
        return $this->commentsRepository->getCommentsPaginated(
            self::$order_field,
            self::$order_direction,
            self::$limit
        );
    }
}
