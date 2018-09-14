<?php
namespace Http\Actions\GetDashboard;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Domain\User\Commands\GetLastRegisteredUsers;
use Domain\Post\Commands\GetLastPosts;
use Domain\Post\Commands\GetLastPendingPosts;
use Domain\Post\Commands\GetLastDraftPosts;
use Domain\Comment\Commands\GetLastComments;

class GetDashboardAction
{
    protected $responder;
    protected $lastRegisteredUsers;
    protected $lastPosts;
    protected $lastPendingPosts;
    protected $lastDraftPosts;
    protected $lastComments;

    public function __construct(
        GetDashboardResponder $responder,
        GetLastRegisteredUsers $lastRegisteredUsers,
        GetLastPosts $lastPosts,
        GetLastPendingPosts $lastPendingPosts,
        GetLastDraftPosts $lastDraftPosts,
        GetLastComments $lastComments
    ) {
        $this->responder = $responder;
        $this->lastRegisteredUsers = $lastRegisteredUsers;
        $this->lastPosts = $lastPosts;
        $this->lastPendingPosts = $lastPendingPosts;
        $this->lastDraftPosts = $lastDraftPosts;
        $this->lastComments = $lastComments;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->responder->setLastRegisteredUsers($this->lastRegisteredUsers->load());
        $this->responder->setLastPosts($this->lastPosts->load());
        $this->responder->setLastPendingPosts($this->lastPendingPosts->load());
        $this->responder->setLastDraftPosts($this->lastDraftPosts->load());
        $this->responder->setLastComments($this->lastComments->load());
        $this->responder->success($response);
    }
}
