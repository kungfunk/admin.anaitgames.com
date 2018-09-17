<?php
namespace Domain\Post\Commands;

use Domain\Post\PostsRepository;
use Carbon\Carbon;

class CountPostsByDate
{
    private $repository;
    private $startDate;
    private $endDate;

    public function __construct(PostsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function setStartDate(Carbon $date)
    {
        $this->startDate = $date;
    }

    public function setEndDate(Carbon $date)
    {
        $this->endDate = $date;
    }

    public function load()
    {
        return $this->repository->countPostsFromDate($this->startDate, $this->endDate);
    }
}