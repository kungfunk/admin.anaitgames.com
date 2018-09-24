<?php
namespace Domain\Post\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\Post\PostsRepository;

class CountPostsByStatus implements CommandInterface
{
    private $postsRepository;
    private $status;

    public function __construct()
    {
        $this->postsRepository = new PostsRepository;
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
