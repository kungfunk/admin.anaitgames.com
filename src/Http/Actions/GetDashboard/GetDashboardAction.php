<?php
namespace Http\Actions\GetDashboard;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Carbon\Carbon;

use Domain\User\Commands\GetLastRegisteredUsers;
use Domain\User\Commands\CountUsersByDate;
use Domain\Post\Commands\GetLastPosts;
use Domain\Post\Commands\GetLastPendingPosts;
use Domain\Post\Commands\GetLastDraftPosts;
use Domain\Post\Commands\CountPostsByDate;
use Domain\Comment\Commands\GetLastComments;
use Domain\Comment\Commands\CountCommentsByDate;

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
        CountUsersByDate $usersByDate,
        GetLastPosts $lastPosts,
        GetLastPendingPosts $lastPendingPosts,
        GetLastDraftPosts $lastDraftPosts,
        CountPostsByDate $postsByDate,
        GetLastComments $lastComments,
        CountCommentsByDate $commentsByDate
    ) {
        $this->responder = $responder;
        $this->lastRegisteredUsers = $lastRegisteredUsers;
        $this->usersByDate = $usersByDate;
        $this->lastPosts = $lastPosts;
        $this->lastPendingPosts = $lastPendingPosts;
        $this->lastDraftPosts = $lastDraftPosts;
        $this->postsByDate = $postsByDate;
        $this->lastComments = $lastComments;
        $this->commentsByDate = $commentsByDate;
    }

    public function __invoke(Request $request, Response $response)
    {
        $startOfToday = new Carbon('today');
        $endOfToday = new Carbon('today');
        $endOfToday->modify('+1 day');

        $startOfYesterday = new Carbon('yesterday');
        $endOfYesterday = new Carbon('yesterday');
        $endOfYesterday->modify('+1 day');

        $this->postsByDate->setStartDate($startOfToday);
        $this->postsByDate->setEndDate($endOfToday);
        $number_of_posts_today = $this->postsByDate->load();

        $this->postsByDate->setStartDate($startOfYesterday);
        $this->postsByDate->setEndDate($endOfYesterday);
        $number_of_posts_yesterday = $this->postsByDate->load();

        $this->usersByDate->setStartDate($startOfToday);
        $this->usersByDate->setEndDate($endOfToday);
        $number_of_users_today = $this->usersByDate->load();

        $this->usersByDate->setStartDate($startOfYesterday);
        $this->usersByDate->setEndDate($endOfYesterday);
        $number_of_users_yesterday = $this->usersByDate->load();

        $this->commentsByDate->setStartDate($startOfToday);
        $this->commentsByDate->setEndDate($endOfToday);
        $number_of_comments_today = $this->commentsByDate->load();

        $this->commentsByDate->setStartDate($startOfYesterday);
        $this->commentsByDate->setEndDate($endOfYesterday);
        $number_of_comments_yesterday = $this->commentsByDate->load();

        $this->responder->setLastRegisteredUsers($this->lastRegisteredUsers->load());
        $this->responder->setLastPosts($this->lastPosts->load());
        $this->responder->setLastPendingPosts($this->lastPendingPosts->load());
        $this->responder->setLastDraftPosts($this->lastDraftPosts->load());
        $this->responder->setLastComments($this->lastComments->load());
        $this->responder->setNumberOfPostToday($number_of_posts_today);
        $this->responder->setNumberOfPostYesterday($number_of_posts_yesterday);
        $this->responder->setNumberOfUsersToday($number_of_users_today);
        $this->responder->setNumberOfUsersYesterday($number_of_users_yesterday);
        $this->responder->setNumberOfCommentsToday($number_of_comments_today);
        $this->responder->setNumberOfCommentsYesterday($number_of_comments_yesterday);
        $this->responder->success($response);
    }
}
