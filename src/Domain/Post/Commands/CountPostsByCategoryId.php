<?php
namespace Domain\Post\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\Post\PostsRepository;

class CountPostsByCategoryId implements CommandInterface
{
    private $postsRepository;
    private $categoryId;

    public function __construct()
    {
        $this->postsRepository = new PostsRepository;
    }

    public function setCategoryId(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function run()
    {
        $this->postsRepository->newQuery();

        $this->postsRepository->setFilters(
            null,
            $this->categoryId
        );

        return $this->postsRepository->count();
    }
}
