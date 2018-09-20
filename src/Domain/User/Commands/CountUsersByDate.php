<?php
namespace Domain\User\Commands;

use App\Commands\CommandInterface;
use Domain\User\UsersRepository;
use Carbon\Carbon;

class CountUsersByDate implements CommandInterface
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

    public function run()
    {
        return $this->repository->countUsersFromDate($this->startDate, $this->endDate);
    }
}
