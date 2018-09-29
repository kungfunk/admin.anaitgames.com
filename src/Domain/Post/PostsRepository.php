<?php
namespace Domain\Post;

use Carbon\Carbon;

class PostsRepository
{
    private $postModel;
    private $query;

    public function __construct()
    {
        $this->postModel = new Post;
        $this->reset();
    }

    private function reset()
    {
        $this->query = $this->postModel->query();
    }

    public function get($resetAfterQuery = true)
    {
        $result = $this->query->get();

        if ($resetAfterQuery) {
            $this->reset();
        }

        return $result;
    }

    public function count($resetAfterQuery = true)
    {
        $result = $this->query->count();

        if ($resetAfterQuery) {
            $this->reset();
        }

        return $result;
    }

    public function addRelationShips()
    {
        $this->query
            ->withCount('comments')
            ->with('category')
            ->with('user')
            ->with('tags');

        return $this;
    }

    public function setOrderAndPagination(
        string $orderField = Post::DEFAULT_ORDER_FIELD,
        string $orderDirection = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $this->query
            ->orderBy($orderField, $orderDirection)
            ->offset($offset)
            ->limit($limit);

        return $this;
    }

    public function setLast(int $number)
    {
        $this->setOrderAndPagination(
            Post::DEFAULT_ORDER_FIELD,
            Post::DEFAULT_ORDER_DIRECTION,
            $number
        );
        return $this;
    }

    public function setFilters(
        string $search = null,
        int $categoryId = null,
        int $userId = null,
        string $status = null
    ) {
        if (!is_null($search)) {
            $this->setSearch($search);
        }

        if (!is_null($userId)) {
            $this->setUserId($userId);
        }

        if (!is_null($categoryId)) {
            $this->setCategoryId($categoryId);
        }

        if (!is_null($status)) {
            $this->setStatus($status);
        }

        return $this;
    }

    public function setSearch($search)
    {
        $this->query->where(
            'title',
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

    public function setCategoryId($categoryId)
    {
        $this->query->where('category_id', $categoryId);
        return $this;
    }

    public function setStatus($status)
    {
        $this->query->where('status', $status);
        return $this;
    }

    public function setPublishDateMoreThan(Carbon $date)
    {
        $this->query->where('publish_date', '>', $date);
        return $this;
    }

    public function setPublishDateLessThan(Carbon $date)
    {
        $this->query->where('publish_date', '<', $date);
        return $this;
    }

    public function setPublishDateBetween(Carbon $startDate, Carbon $endDate)
    {
        $this->query->whereBetween('created_at', [$startDate, $endDate]);
        return $this;
    }
}
