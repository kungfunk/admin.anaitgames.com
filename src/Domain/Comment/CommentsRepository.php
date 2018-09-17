<?php
namespace Domain\Comment;

use Carbon\Carbon;

class CommentsRepository
{
    private $comment_model;

    public function __construct(Comment $comment)
    {
        $this->comment_model = $comment;
    }

    public function getCommentsPaginated(
        string $order_field = Comment::DEFAULT_ORDER_FIELD,
        string $order_direction = Comment::DEFAULT_ORDER_DIRECTION,
        int $limit = Comment::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        return $this->comment_model
            ->orderBy($order_field, $order_direction)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function countCommentsFromDate(Carbon $startDate, Carbon $endDate)
    {
        return $this->comment_model
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
