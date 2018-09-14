<?php
namespace Http\Actions\GetDashboard;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Domain\User\Commands\GetLastRegisteredUsers;
use Domain\Post\Commands\GetLastPosts;

class GetDashboardAction
{
    protected $responder;
    protected $lastRegisteredUsers;
    protected $lastPosts;

    public function __construct(
        GetDashboardResponder $responder,
        GetLastRegisteredUsers $lastRegisteredUsers,
        GetLastPosts $lastPosts
    ) {
        $this->responder = $responder;
        $this->lastRegisteredUsers = $lastRegisteredUsers;
        $this->lastPosts = $lastPosts;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->responder->setLastRegisteredUsers($this->lastRegisteredUsers->load());
        $this->responder->setLastPosts($this->lastPosts->load());
        $this->responder->success($response);
    }
}
