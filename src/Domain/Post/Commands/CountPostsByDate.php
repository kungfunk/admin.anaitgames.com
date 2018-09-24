<?php
namespace Domain\Post\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\Post\PostsRepository;
use Carbon\Carbon;

class CountPostsByDate implements CommandInterface
{
    private $postsRepository;
    private $startDate;
    private $endDate;

    public function __construct()
    {
        $this->postsRepository = new PostsRepository;
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
        $this->postsRepository->newQuery();

        $this->postsRepository->setPublishDateMoreThan($this->startDate);
        $this->postsRepository->setPublishDateLessThan($this->endDate);

        return $this->postsRepository->count();
    }
}
