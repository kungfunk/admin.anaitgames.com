<?php
namespace Domain\User;

use Domain\Repository;

class LogsRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Log;
        parent::__construct();
    }

    public function getLogsFromUserIdPaginated($user_id, $options)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->orderBy(Log::FIXED_ORDER, $options['order'])
            ->offset($options['offset'])
            ->limit($options['limit'])
            ->get();
    }
}
