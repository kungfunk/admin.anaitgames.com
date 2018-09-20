<?php
namespace Domain\User;

class LogsRepository
{
    private $logsModel;

    public function __construct()
    {
        $this->logsModel = new Log;
    }

    public function getLogsFromUserIdPaginated($user_id, $options)
    {
        return $this->logsModel
            ->where('user_id', $user_id)
            ->orderBy(Log::FIXED_ORDER, $options['order'])
            ->offset($options['offset'])
            ->limit($options['limit'])
            ->get();
    }
}
