<?php
namespace Http\Actions\GetDashboard;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Domain\User\Commands\GetLastFiveRegisteredUsers;

class GetDashboardAction
{
    protected $responder;
    protected $lastFiveRegisteredUsers;

    public function __construct(
        GetDashboardResponder $responder,
        GetLastFiveRegisteredUsers $lastFiveRegisteredUsers
    ) {
        $this->responder = $responder;
        $this->lastFiveRegisteredUsers = $lastFiveRegisteredUsers;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->responder->setLastFiveRegisteredUsers($this->lastFiveRegisteredUsers->load());
        $this->responder->success($response);
    }
}
