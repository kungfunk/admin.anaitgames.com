<?php
namespace Http\Actions\GetPosts;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;

use Slim\Views\Twig;
use Illuminate\Database\Eloquent\Collection;

class GetPostsResponder extends Responder
{
    private $twig;
    private $data;

    private const DASHBOARD_TEMPLATE_ROUTE = 'routes/posts.twig';

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
        $this->data = [];
    }

    public function setPosts(Collection $posts)
    {
        $this->data['posts'] = $posts;
    }

    public function setTotalPostsNumber(int $number)
    {
        $this->data['total_posts_number'] = $number;
    }

    public function setCategories(Collection $categories)
    {
        $this->data['categories'] = $categories;
    }

    public function setDraftPostsNumber(int $count)
    {
        $this->data['draft_posts_number'] = $count;
    }

    public function setPublishedPostsNumber(int $count)
    {
        $this->data['published_posts_number'] = $count;
    }

    public function setTrashPostsNumber(int $count)
    {
        $this->data['trash_posts_number'] = $count;
    }

    public function setWriters(Collection $users)
    {
        $this->data['writers'] = $users;
    }

    public function success(Response $response)
    {
        return $this->twig->render(
            $response,
            self::DASHBOARD_TEMPLATE_ROUTE,
            $this->data
        );
    }
}
