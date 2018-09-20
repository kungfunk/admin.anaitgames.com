<?php
namespace Domain\Post;

use Carbon\Carbon;

class PostsRepository
{
    private $postModel;

    public function __construct(Post $post)
    {
        $this->postModel = $post;
    }

    private function addRelationShips($query)
    {
        return $query
            ->withCount('comments')
            ->with('category')
            ->with('user')
            ->with('tags');
    }

    private function addOrder($query, $orderField, $orderDirection, $limit, $offset)
    {
        return $query
            ->orderBy($orderField, $orderDirection)
            ->offset($offset)
            ->limit($limit);
    }

    public function getPostById($id)
    {
        return $this->postModel->find($id);
    }

    public function getDraftPostsPaginated(
        string $orderField = Post::DEFAULT_ORDER_FIELD,
        string $orderDirection = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $query = $this->postModel
            ->where('status', Post::STATUS_DRAFT);

        $query = $this->addRelationShips($query);
        $query = $this->addOrder($query, $orderField, $orderDirection, $limit, $offset);

        return $query->get();
    }

    public function getNotPublishedPostsPaginated(
        string $orderField = Post::DEFAULT_ORDER_FIELD,
        string $orderDirection = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {

        $query = $this->postModel
            ->where('status', Post::STATUS_PUBLISHED)
            ->where('publish_date', '>', Carbon::now()->toDateTimeString());

        $query = $this->addRelationShips($query);
        $query = $this->addOrder($query, $orderField, $orderDirection, $limit, $offset);

        return $query->get();
    }

    public function getPostsPaginated(
        string $orderField = Post::DEFAULT_ORDER_FIELD,
        string $orderDirection = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $query = $this->postModel;
        $query = $this->addRelationShips($query);
        $query = $this->addOrder($query, $orderField, $orderDirection, $limit, $offset);

        return $query->get();
    }

    public function countPosts()
    {
        return $this->postModel->count();
    }

    public function countPostsByCategoryId(int $categoryId)
    {
        return $this->postModel
            ->where('category_id', $categoryId)
            ->count();
    }


    public function countPostsFromDate(Carbon $startDate, Carbon $endDate)
    {
        return $this->postModel
            ->whereBetween('publish_date', [$startDate, $endDate])
            ->count();
    }

    public function getPostsFilteredPaginated(
        string $search = null,
        int $categoryId = null,
        string $status = null,
        string $orderField = Post::DEFAULT_ORDER_FIELD,
        string $orderDirection = Post::DEFAULT_ORDER_DIRECTION,
        int $limit = Post::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $query = $this->postModel->query();

        if (!is_null($search)) {
            $query = $query->where(
                'title',
                'like',
                '%' . $search . '%'
            );
        }

        if (!is_null($categoryId)) {
            $query = $query->where('category_id', $categoryId);
        }

        if (!is_null($status)) {
            $query = $query->where('status', $status);
        }

        $query = $this->addRelationShips($query);
        $query = $this->addOrder($query, $orderField, $orderDirection, $limit, $offset);

        return $query->get();
    }
}
