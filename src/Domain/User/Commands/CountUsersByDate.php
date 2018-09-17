<?php
namespace Domain\User\Commands;

use Domain\User\UsersRepository;
use Carbon\Carbon;

class CountUsersByDate
{
    private $repository;
    private $startDate;
    private $endDate;

    public function __construct(UsersRepository $repository)
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
        return $this->repository->countUsersFromDate($this->startDate, $this->endDate);
    }
}