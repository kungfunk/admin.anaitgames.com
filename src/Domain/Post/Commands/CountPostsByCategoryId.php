<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\PostsRepository;

class CountPostsByCategoryId implements CommandInterface
{
    private $postsRepository;
    private $categoryId;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function setCategoryId(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function run()
    {
        return $this->postsRepository->countPostsByCategoryId($this->categoryId);
    }
}