<?php
namespace Http\Actions\GetLogs;

use Http\Actions\Responder as Responder;

class GetLogsResponder extends Responder
{
    public const TEMPLATE = 'routes/logs.twig';
}
