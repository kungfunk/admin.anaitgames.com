<?php
namespace Http\Actions\GetDashboard;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;

use Slim\Views\Twig;
use Illuminate\Support\Collection;

class GetDashboardResponder extends Responder
{
    private $twig;

    private $lastRegisteredUsers;
    private $lastPosts;
    private $lastPendingPosts;
    private $lastDraftPosts;
    private $lastComments;
    private $numberOfPostsToday;
    private $numberOfPostsYesterday;
    private $numberOfUsersToday;
    private $numberOfUsersYesterday;
    private $numberOfCommentsToday;
    private $numberOfCommentsYesterday;

    private const DASHBOARD_TEMPLATE_ROUTE = 'routes/dashboard.twig';

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function setLastRegisteredUsers(Collection $lastRegisteredUsers)
    {
        $this->lastRegisteredUsers = $lastRegisteredUsers;
    }

    public function setLastPosts(Collection $lastPosts)
    {
        $this->lastPosts = $lastPosts;
    }

    public function setLastPendingPosts(Collection $lastPendingPosts)
    {
        $this->lastPendingPosts = $lastPendingPosts;
    }

    public function setLastDraftPosts(Collection $lastDraftPosts)
    {
        $this->lastDraftPosts = $lastDraftPosts;
    }

    public function setLastComments(Collection $lastComments)
    {
        $this->lastComments = $lastComments;
    }

    public function setNumberOfPostsToday(int $numberOfPostsToday)
    {
        $this->numberOfPostsToday = $numberOfPostsToday;
    }

    public function setNumberOfPostsYesterday(int $numberOfPostsYesterday)
    {
        $this->numberOfPostsYesterday = $numberOfPostsYesterday;
    }

    public function setNumberOfUsersToday(int $numberOfUsersToday)
    {
        $this->numberOfUsersToday = $numberOfUsersToday;
    }

    public function setNumberOfUsersYesterday(int $numberOfUsersYesterday)
    {
        $this->numberOfUsersYesterday = $numberOfUsersYesterday;
    }

    public function setNumberOfCommentsToday(int $numberOfCommentsToday)
    {
        $this->numberOfCommentsToday = $numberOfCommentsToday;
    }

    public function setNumberOfCommentsYesterday(int $numberOfCommentsYesterday)
    {
        $this->numberOfCommentsYesterday = $numberOfCommentsYesterday;
    }

    public function toHtml(Response $response)
    {
        return $this->twig->render(
            $response,
            self::DASHBOARD_TEMPLATE_ROUTE,
            [
                'lastRegisteredUsers' => $this->lastRegisteredUsers,
                'lastPosts' => $this->lastPosts,
                'lastPendingPosts' => $this->lastPendingPosts,
                'lastDraftPosts' => $this->lastDraftPosts,
                'lastComments' => $this->lastComments,
                'numberOfPostsToday' => $this->numberOfPostsToday,
                'numberOfPostsYesterday' => $this->numberOfPostsYesterday,
                'numberOfUsersToday' => $this->numberOfUsersToday,
                'numberOfUsersYesterday' => $this->numberOfUsersYesterday,
                'numberOfCommentsToday' => $this->numberOfCommentsToday,
                'numberOfCommentsYesterday' => $this->numberOfCommentsYesterday
            ]
        );
    }
}
