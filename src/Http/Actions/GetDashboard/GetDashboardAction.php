<?php
namespace Http\Actions\GetDashboard;

use Carbon\Carbon;

use Domain\Comment\Comment;
use Domain\Post\Post;
use Domain\User\User;
use Http\Actions\Action;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetDashboard\GetDashboardResponder as Responder;

class GetDashboardAction extends Action
{
    const LISTS_ITEMS = 10;

    private $responder;
    private $output = [];

    public function __invoke(Request $request, Response $response)
    {
        $yesterday = new Carbon('yesterday');
        $today = new Carbon('today');
        $tomorrow = new Carbon('tomorrow');

        $this->output = [
            'postsTodayCount' => $this->postsRepository->setPublishDateBetween($today, $tomorrow)->count(),
            'postsYesterdayCount' => $this->postsRepository->setPublishDateBetween($yesterday, $today)->count(),
            'usersTodayCount' => $this->usersRepository->countUsersFromDate($today, $tomorrow),
            'usersYesterdayCount' => $this->usersRepository->countUsersFromDate($yesterday, $today),
            'commentsTodayCount' => $this->commentsRepository->countCommentsFromDate($today, $tomorrow),
            'commentsYesterdayCount' => $this->commentsRepository->countCommentsFromDate($yesterday, $today),
            'lastRegisteredUsers' => $this->usersRepository
                ->getUsersPaginated(User::DEFAULT_ORDER_FIELD, User::DEFAULT_ORDER_FIELD, self::LISTS_ITEMS),
            'lastPosts' => $this->postsRepository->setLast(10)->get(),
            'lastPendingPosts' => $this->postsRepository
                ->setStatus(Post::STATUS_PUBLISHED)
                ->setPublishDateMoreThan(Carbon::now())
                ->setLast(self::LISTS_ITEMS)
                ->get(),
            'lastDraftPosts' => $this->postsRepository
                ->setStatus(Post::STATUS_DRAFT)
                ->setLast(self::LISTS_ITEMS)
                ->get(),
            'lastComments' => $this->commentsRepository
                ->getCommentsPaginated(
                    Comment::DEFAULT_ORDER_FIELD,
                    Comment::DEFAULT_ORDER_DIRECTION,
                    self::LISTS_ITEMS
                ),
        ];

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
