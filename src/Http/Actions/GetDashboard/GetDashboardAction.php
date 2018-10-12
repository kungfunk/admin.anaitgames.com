<?php
namespace Http\Actions\GetDashboard;

use Carbon\Carbon;

use Http\Actions\Action;
use Slim\Http\Request;
use Slim\Http\Response;
use Http\Actions\GetDashboard\GetDashboardResponder as Responder;

use Models\Comment;
use Models\Post;
use Models\User;

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
            'postsTodayCount' => Post::whereBetween('publish_date', [$today, $tomorrow])->count(),
            'postsYesterdayCount' => Post::whereBetween('publish_date', [$yesterday, $today])->count(),
            'usersTodayCount' => User::whereBetween('created_at', [$today, $tomorrow])->count(),
            'usersYesterdayCount' => User::whereBetween('created_at', [$yesterday, $today])->count(),
            'commentsTodayCount' => Comment::whereBetween('created_at', [$today, $tomorrow])->count(),
            'commentsYesterdayCount' => Comment::whereBetween('created_at', [$yesterday, $today])->count(),
            'lastRegisteredUsers' => User::orderBy(User::DEFAULT_ORDER_FIELD, User::DEFAULT_ORDER_DIRECTION)
                ->limit(self::LISTS_ITEMS)->get(),
            'lastPosts' => Post::orderBy(Post::DEFAULT_ORDER_FIELD, Post::DEFAULT_ORDER_DIRECTION)
                ->limit(self::LISTS_ITEMS)->get(),
            'lastPendingPosts' => Post::whereStatus(Post::STATUS_PUBLISHED)
                ->where('publish_date', '>', Carbon::now())
                ->orderBy(Post::DEFAULT_ORDER_FIELD, Post::DEFAULT_ORDER_DIRECTION)
                ->limit(self::LISTS_ITEMS)
                ->get(),
            'lastDraftPosts' => Post::whereStatus(Post::STATUS_DRAFT)
                ->orderBy(Post::DEFAULT_ORDER_FIELD, Post::DEFAULT_ORDER_DIRECTION)
                ->limit(self::LISTS_ITEMS)
                ->get(),
            'lastComments' => Comment::orderBy(Comment::DEFAULT_ORDER_FIELD, Comment::DEFAULT_ORDER_DIRECTION)
                ->limit(self::LISTS_ITEMS)
                ->get(),
        ];

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
