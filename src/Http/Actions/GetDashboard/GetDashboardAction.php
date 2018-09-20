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
    protected $countCommentsByDate;
    protected $countPostsByDate;

    public function __construct(
        GetDashboardResponder $responder,
        GetLastRegisteredUsers $lastRegisteredUsers,
        CountUsersByDate $countUsersByDate,
        GetLastPosts $lastPosts,
        GetLastPendingPosts $lastPendingPosts,
        GetLastDraftPosts $lastDraftPosts,
        CountPostsByDate $countPostsByDate,
        GetLastComments $lastComments,
        CountCommentsByDate $countCommentsByDate
    ) {
        $this->responder = $responder;
        $this->lastRegisteredUsers = $lastRegisteredUsers;
        $this->countUsersByDate = $countUsersByDate;
        $this->lastPosts = $lastPosts;
        $this->lastPendingPosts = $lastPendingPosts;
        $this->lastDraftPosts = $lastDraftPosts;
        $this->countPostsByDate = $countPostsByDate;
        $this->lastComments = $lastComments;
        $this->countCommentsByDate = $countCommentsByDate;
    }

    public function __invoke(Request $request, Response $response)
    {
        $startOfToday = new Carbon('today');
        $endOfToday = new Carbon('today');
        $endOfToday->modify('+1 day');

        $startOfYesterday = new Carbon('yesterday');
        $endOfYesterday = new Carbon('yesterday');
        $endOfYesterday->modify('+1 day');

        $this->countPostsByDate->setStartDate($startOfToday);
        $this->countPostsByDate->setEndDate($endOfToday);
        $number_of_posts_today = $this->countPostsByDate->run();

        $this->countPostsByDate->setStartDate($startOfYesterday);
        $this->countPostsByDate->setEndDate($endOfYesterday);
        $number_of_posts_yesterday = $this->countPostsByDate->run();

        $this->countUsersByDate->setStartDate($startOfToday);
        $this->countUsersByDate->setEndDate($endOfToday);
        $number_of_users_today = $this->countUsersByDate->run();

        $this->countUsersByDate->setStartDate($startOfYesterday);
        $this->countUsersByDate->setEndDate($endOfYesterday);
        $number_of_users_yesterday = $this->countUsersByDate->run();

        $this->countCommentsByDate->setStartDate($startOfToday);
        $this->countCommentsByDate->setEndDate($endOfToday);
        $number_of_comments_today = $this->countCommentsByDate->run();

        $this->countCommentsByDate->setStartDate($startOfYesterday);
        $this->countCommentsByDate->setEndDate($endOfYesterday);
        $number_of_comments_yesterday = $this->countCommentsByDate->run();

        $this->responder->setLastRegisteredUsers($this->lastRegisteredUsers->run());
        $this->responder->setLastPosts($this->lastPosts->run());
        $this->responder->setLastPendingPosts($this->lastPendingPosts->run());
        $this->responder->setLastDraftPosts($this->lastDraftPosts->run());
        $this->responder->setLastComments($this->lastComments->run());
        $this->responder->setNumberOfPostToday($number_of_posts_today);
        $this->responder->setNumberOfPostYesterday($number_of_posts_yesterday);
        $this->responder->setNumberOfUsersToday($number_of_users_today);
        $this->responder->setNumberOfUsersYesterday($number_of_users_yesterday);
        $this->responder->setNumberOfCommentsToday($number_of_comments_today);
        $this->responder->setNumberOfCommentsYesterday($number_of_comments_yesterday);
        $this->responder->success($response);
    }
}
