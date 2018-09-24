<?php
namespace Domain\Post\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\Post\PostsRepository;

class CountPostsFiltered implements CommandInterface
{
    private $postsRepository;
    private $categoryId;
    private $search;
    private $status;
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

    public function setUserId(int $userId = null)
    {
        $this->userId = $userId;
    }

    public function run()
    {
        $this->postsRepository->newQuery();

        $this->postsRepository->setFilters(
            $this->search,
            $this->categoryId,
            $this->userId,
            $this->status
        );

        return $this->postsRepository->count();
    }
}
