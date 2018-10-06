<?php
namespace Domain\Comment;

use Carbon\Carbon;
use Domain\Repository;

class CommentsRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Comment;
        parent::__construct();
    }

    public function addRelationShips()
    {
        $this->query
            ->withCount('reports')
            ->with('user')
            ->with('post');

        return $this;
    }

    public function setFilters(
        string $search = null,
        int $userId = null,
        int $postId = null
    ) {
        if (!is_null($search)) {
            $this->setSearch($search);
        }

        if (!is_null($userId)) {
            $this->setUserId($userId);
        }

        if (!is_null($postId)) {
            $this->setPostId($status);
        }

        return $this;
    }

    public function setSearch($search)
    {
        $this->query->where(
            'body',
            'like',
            '%' . $search . '%'
        );

        return $this;
    }

    public function setUserId($userId)
    {
        $this->query->where('user_id', $userId);
        return $this;
    }

    public function setPostId($postId)
    {
        $this->query->where('post_id', $postId);
        return $this;
    }

    public function setOrderAndPagination(
        string $orderField = Comment::DEFAULT_ORDER_FIELD,
        string $orderDirection = Comment::DEFAULT_ORDER_DIRECTION,
        int $limit = Comment::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $this->query
            ->orderBy($orderField, $orderDirection)
            ->offset($offset)
            ->limit($limit);

        return $this;
    }

    public function getCommentsPaginated(
        string $order_field = Comment::DEFAULT_ORDER_FIELD,
        string $order_direction = Comment::DEFAULT_ORDER_DIRECTION,
        int $limit = Comment::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        return $this->model
            ->orderBy($order_field, $order_direction)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function countCommentsFromDate(Carbon $startDate, Carbon $endDate)
    {
        return $this->model
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
