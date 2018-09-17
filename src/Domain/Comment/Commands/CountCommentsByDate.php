<?php
namespace Domain\Comment\Commands;

use Domain\Comment\CommentsRepository;
use Carbon\Carbon;

class CountCommentsByDate
{
    private $repository;
    private $startDate;
    private $endDate;

    public function __construct(CommentsRepository $repository)
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
        return $this->repository->countCommentsFromDate($this->startDate, $this->endDate);
    }
}