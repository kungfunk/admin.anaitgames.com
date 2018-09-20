<?php
namespace Domain\Post\Commands;

use App\Commands\CommandInterface;
use Domain\Post\PostsRepository;
use Carbon\Carbon;

class CountPostsByDate implements CommandInterface
{
    private $postsRepository;
    private $startDate;
    private $endDate;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function setStartDate(Carbon $date)
    {
        $this->startDate = $date;
    }

    public function setEndDate(Carbon $date)
    {
        $this->endDate = $date;
    }

    public function run()
    {
        return $this->postsRepository->countPostsFromDate($this->startDate, $this->endDate);
    }
}
