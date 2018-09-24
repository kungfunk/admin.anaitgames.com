<?php
namespace Domain\Post\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\Post\PostsRepository;

class GetPostsFilteredPaginated implements CommandInterface
{
    private $postsRepository;
    private $search;
    private $categoryId;
    private $status;
    private $orderField;
    private $orderDirection;
    private $limit;
    private $page;
    private $userId;

    public function __construct()
    {
        $this->postsRepository = new PostsRepository;
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

    public function setPage(int $page = 0)
    {
        $this->page = $page;
    }

    public function setLimit(int $limit = 100)
    {
        $this->limit = $limit;
    }

    public function setUserId(int $userId = null)
    {
        $this->userId = $userId;
    }

    public function run()
    {
        $offset = ($this->page - 1) * $this->limit;

        $this->postsRepository->newQuery();

        $this->postsRepository->setFilters(
            $this->search,
            $this->categoryId,
            $this->userId,
            $this->status
        );

        $this->postsRepository->setOrderAndPagination(
            $this->orderField,
            $this->orderDirection,
            $this->limit,
            $offset
        );

        $this->postsRepository->addRelationShips();

        return $this->postsRepository->get();
    }
}
