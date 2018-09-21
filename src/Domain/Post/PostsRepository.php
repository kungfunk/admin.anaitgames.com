<?php
namespace Domain\Post;

use Carbon\Carbon;

class PostsRepository
{
    private $postModel;
    private $query;

    public function __construct(Post $post)
    {
        $this->postModel = $post;
    }

    public function newQuery()
    {
        $this->query = $this->postModel->query();
    }

    public function get()
    {
        return $this->query->get();
    }

    public function count()
    {
        return $this->query->count();
    }

    public function addRelationShips()
    {
        return $this->query
            ->withCount('comments')
            ->with('category')
            ->with('user')
            ->with('tags');
    }

    public function setOrderAndPagination(
        string $orderField = Post::DEFAULT_ORDER_FIELD,
        string $orderDirection = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        return $this->query
            ->orderBy($orderField, $orderDirection)
            ->offset($offset)
            ->limit($limit);
    }

    public function setFilters(
        string $search = null,
        int $categoryId = null,
        int $userId = null,
        string $status = null
    ) {
        if (!is_null($search)) {
            $this->query->where(
                'title',
                'like',
                '%' . $search . '%'
            );
        }

        if (!is_null($userId)) {
            $this->query->where('user_id', $userId);
        }

        if (!is_null($categoryId)) {
            $this->query->where('category_id', $categoryId);
        }

        if (!is_null($status)) {
            $this->query->where('status', $status);
        }
    }

    public function setPublishDateMoreThan(Carbon $date)
    {
        $this->query->where('publish_date', '>', $date);
    }

    public function setPublishDateLessThan(Carbon $date)
    {
        $this->query->where('publish_date', '<', $date);
    }
}
