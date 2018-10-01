<?php
namespace Infrastructure\Monolog;

use Monolog\Handler\AbstractProcessingHandler;
use Domain\User\Log;
use Monolog\Logger;
use SlimSession\Helper as SessionHelper;

class EloquentHandler extends AbstractProcessingHandler
{
    private $session;

    public function __construct(SessionHelper $session, $level = Logger::DEBUG, $bubble = true)
    {
        $this->session = $session;
        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        if ($this->session->exists('user_id')) {
            $user_id = $this->session->get('user_id');
        } else {
            // This is only for login action case
            $user_id = $record['context']['user_id'];
            unset($record['context']['user_id']);
        }

        Log::create([
            'user_id' => $user_id,
            'level'   => $record['level_name'],
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'extra'   => json_encode($record['extra'])
        ]);
    }
}
