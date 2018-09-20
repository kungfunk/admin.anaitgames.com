<?php
namespace Domain\Comment\Commands;

use App\Commands\CommandInterface;
use Domain\Comment\CommentsRepository;
use Carbon\Carbon;

class CountCommentsByDate implements CommandInterface
{
    private $commentsRepository;
    private $startDate;
    private $endDate;

    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
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
        return $this->commentsRepository->countCommentsFromDate($this->startDate, $this->endDate);
    }
}
