<?php
namespace Http\Actions\GetDashboard;

use Carbon\Carbon;

use Http\Actions\Action;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetDashboard\GetDashboardOutput as Output;
use Http\Actions\GetDashboard\GetDashboardResponder as Responder;

use Domain\User\Commands\GetLastRegisteredUsers;
use Domain\User\Commands\CountUsersByDate;
use Domain\Post\Commands\GetLastPosts;
use Domain\Post\Commands\GetLastPendingPosts;
use Domain\Post\Commands\GetLastDraftPosts;
use Domain\Post\Commands\CountPostsByDate;
use Domain\Comment\Commands\GetLastComments;
use Domain\Comment\Commands\CountCommentsByDate;

class GetDashboardAction extends Action
{
    protected $responder;
    protected $output;
    protected $lastRegisteredUsers;
    protected $lastPosts;
    protected $lastPendingPosts;
    protected $lastDraftPosts;
    protected $countCommentsByDate;
    protected $countPostsByDate;

    public function __invoke(Request $request, Response $response)
    {
        $this->responder = new Responder($this->view);
        $this->output = new Output;
        $this->lastRegisteredUsers = new GetLastRegisteredUsers;
        $this->countUsersByDate = new CountUsersByDate;
        $this->lastPosts = new GetLastPosts;
        $this->lastPendingPosts = new GetLastPendingPosts;
        $this->lastDraftPosts = new GetLastDraftPosts;
        $this->countPostsByDate = new CountPostsByDate;
        $this->lastComments = new GetLastComments;
        $this->countCommentsByDate = new CountCommentsByDate;

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

        $this->output->setLastRegisteredUsers($this->lastRegisteredUsers->run());
        $this->output->setLastPosts($this->lastPosts->run());
        $this->output->setLastPendingPosts($this->lastPendingPosts->run());
        $this->output->setLastDraftPosts($this->lastDraftPosts->run());
        $this->output->setLastComments($this->lastComments->run());
        $this->output->setNumberOfPostsToday($number_of_posts_today);
        $this->output->setNumberOfPostsYesterday($number_of_posts_yesterday);
        $this->output->setNumberOfUsersToday($number_of_users_today);
        $this->output->setNumberOfUsersYesterday($number_of_users_yesterday);
        $this->output->setNumberOfCommentsToday($number_of_comments_today);
        $this->output->setNumberOfCommentsYesterday($number_of_comments_yesterday);

        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
