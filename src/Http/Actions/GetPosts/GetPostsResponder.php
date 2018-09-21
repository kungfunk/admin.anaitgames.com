<?php
namespace Http\Actions\GetPosts;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;

use Slim\Views\Twig;
use JasonGrimes\Paginator;
use Illuminate\Database\Eloquent\Collection;

class GetPostsResponder extends Responder
{
    private $twig;

    private $posts;
    private $totalPostsNumber;
    private $categories;
    private $draftPostsNumber;
    private $publishedPostsNumber;
    private $trashPostsNumber;
    private $writers;
    private $page;
    private $pagination;

    public const POSTS_PER_PAGE = 10;

    private const DASHBOARD_TEMPLATE_ROUTE = 'routes/posts.twig';

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function setPosts(Collection $posts)
    {
        $this->posts = $posts;
    }

    public function setTotalPostsNumber(int $totalPostsNumber)
    {
        $this->totalPostsNumber = $totalPostsNumber;
    }

    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;
    }

    public function setDraftPostsNumber(int $draftPostsNumber)
    {
        $this->draftPostsNumber = $draftPostsNumber;
    }

    public function setPublishedPostsNumber(int $publishedPostsNumber)
    {
        $this->publishedPostsNumber = $publishedPostsNumber;
    }

    public function setTrashPostsNumber(int $trashPostsNumber)
    {
        $this->trashPostsNumber = $trashPostsNumber;
    }

    public function setWriters(Collection $writers)
    {
        $this->writers = $writers;
    }

    public function setPage(int $page)
    {
        $this->page = $page;
    }

    public function setPostsPagination()
    {
        $this->pagination = new Paginator(
            $this->totalPostsNumber,
            self::POSTS_PER_PAGE,
            $this->page,
            '/posts?page=(:num)'
        );
    }

    public function success(Response $response)
    {
        return $this->twig->render(
            $response,
            self::DASHBOARD_TEMPLATE_ROUTE,
            [
                'posts' => $this->posts,
                'totalPostsNumber' => $this->totalPostsNumber,
                'categories' => $this->categories,
                'draftPostsNumber' => $this->draftPostsNumber,
                'publishedPostsNumber' => $this->publishedPostsNumber,
                'trashPostsNumber' => $this->trashPostsNumber,
                'writers' => $this->writers,
                'page' => $this->page,
                'pagination' => $this->pagination
            ]
        );
    }
}
