<?php
namespace Domain\User\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\User\UsersRepository;
use Carbon\Carbon;

class CountUsersByDate implements CommandInterface
{
    private $repository;
    private $startDate;
    private $endDate;

    public function __construct()
    {
        $this->repository = new UsersRepository;
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
        return $this->repository->countUsersFromDate($this->startDate, $this->endDate);
    }
}
