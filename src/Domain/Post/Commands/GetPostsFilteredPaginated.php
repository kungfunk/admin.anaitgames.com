<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\PostsRepository;

class GetPostsFilteredPaginated implements CommandInterface
{
    private $postsRepository;
    private $search;
    private $categoryId;
    private $status;
    private $orderField;
    private $orderDirection;
    private $offset;
    private static $limit = 50;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function setSearch(string $search = null)
    {
        $this->search = $search;
    }

    public function setCategoryId(string $categoryId = null)
    {
        $this->categoryId = $categoryId;
    }

    public function setStatus(string $status = null)
    {
        $this->status = $status;
    }

    public function setOrderField(string $orderField = null)
    {
        $this->orderField = $orderField;
    }

    public function setOrderDirection(string $orderDirection = null)
    {
        $this->orderDirection = $orderDirection;
    }

    public function setOffset(int $offset = null)
    {
        $this->offset = $offset;
    }

    public function run()
    {
        return $this->postsRepository->getPostsFilteredPaginated(
            $this->search,
            $this->categoryId,
            $this->status,
            $this->orderField,
            $this->orderDirection,
            self::$limit,
            $this->offset
        );
    }
}
