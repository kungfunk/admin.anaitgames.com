<?php
namespace Http\Actions\GetPosts;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;
use Http\Actions\GetPosts\GetPostsInput as Input;

use Slim\Views\Twig;
use Http\Helpers\Pagination;
use Illuminate\Database\Eloquent\Collection;

class GetPostsResponder extends Responder
{
    public const POSTS_PER_PAGE = 20;
    private const DASHBOARD_TEMPLATE_ROUTE = 'routes/posts.twig';
    private const BASE_URL = '/posts';

    private $twig;

    private $posts;
    private $totalPostsNumber;
    private $categories;
    private $writers;
    private $page;
    private $pagination;
    private $paginationParameters;
    private $statusFilters;

    public function __construct(Twig $twig, Pagination $pagination)
    {
        $this->twig = $twig;
        $this->pagination = $pagination;
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

    public function setWriters(Collection $writers)
    {
        $this->writers = $writers;
    }

    public function setPage(int $page)
    {
        $this->page = $page;
    }

    public function setStatusFilters(array $statusFilters)
    {
        $this->statusFilters = $statusFilters;
    }

    public function setPaginationParameters(Input $input)
    {
        $paginationParameters = [
            Input::PARAM_ORDER_FIELD => $input->orderField,
            Input::PARAM_ORDER_DIRECTION => $input->orderDirection
        ];

        if (!is_null($input->search)) {
            $paginationParameters[Input::PARAM_SEARCH] = $input->search;
        }

        if (!is_null($input->status)) {
            $paginationParameters[Input::PARAM_STATUS] = $input->status;
        }

        if (!is_null($input->userId)) {
            $paginationParameters[Input::PARAM_AUTHOR] = $input->userId;
        }

        if (!is_null($input->categoryId)) {
            $paginationParameters[Input::PARAM_TYPE] = $input->categoryId;
        }

        $this->paginationParameters = $paginationParameters;
    }

    public function setPostsPagination()
    {
        $this->pagination->setup(
            $this->totalPostsNumber,
            self::POSTS_PER_PAGE,
            $this->page
        );
    }

    public function toHtml(Response $response)
    {
        return $this->twig->render(
            $response,
            self::DASHBOARD_TEMPLATE_ROUTE,
            [
                'posts' => $this->posts,
                'totalPostsNumber' => $this->totalPostsNumber,
                'categories' => $this->categories,
                'writers' => $this->writers,
                'page' => $this->page,
                'pagination' => $this->pagination,
                'paginationParameters' => $this->paginationParameters,
                'baseUrl' => self::BASE_URL,
                'statusFilters' => $this->statusFilters
            ]
        );
    }
}
