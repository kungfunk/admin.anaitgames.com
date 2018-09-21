<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\PostsRepository;

class CountTotalPosts implements CommandInterface
{
    private $postsRepository;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function run()
    {
        $this->postsRepository->newQuery();

        return $this->postsRepository->count();
    }
}
