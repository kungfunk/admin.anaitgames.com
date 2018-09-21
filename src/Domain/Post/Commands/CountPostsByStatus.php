<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\PostsRepository;

class CountPostsByStatus implements CommandInterface
{
    private $postsRepository;
    private $status;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function run()
    {
        $this->postsRepository->newQuery();

        $this->postsRepository->setFilters(
            null,
            null,
            null,
            $this->status
        );

        return $this->postsRepository->count();
    }
}
