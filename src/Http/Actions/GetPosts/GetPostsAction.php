<?php
namespace Http\Actions\GetPosts;

use Http\Helpers\Pagination;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Http\Actions\GetPosts\GetPostsOutput as Output;
use Http\Actions\GetPosts\GetPostsResponder as Responder;
use Interop\Container\ContainerInterface;

use Domain\User\User;
use Domain\Post\Post;
use Domain\Post\Commands\CountPostsFiltered;
use Domain\Post\Commands\GetPostsFilteredPaginated;
use Domain\Post\Commands\GetCategoriesWithPostCount;
use Domain\User\Commands\GetUsersByRole;

class GetPostsAction
{
    public const POSTS_PER_PAGE = 20;
    public const BASE_URL = '/posts';

    private $responder;
    private $input;
    private $output;
    private $pagination;
    private $countPostsFiltered;
    private $getPostsFilteredPaginated;
    private $getCategoriesWithPostCount;
    private $getUsersByRole;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->responder = new Responder($container['view']);
        $this->output = new Output;
        $this->pagination = new Pagination;
        $this->countPostsFiltered = new CountPostsFiltered;
        $this->getPostsFilteredPaginated = new GetPostsFilteredPaginated;
        $this->getCategoriesWithPostCount = new GetCategoriesWithPostCount;
        $this->getUsersByRole = new GetUsersByRole;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->input = new Input($request);

        $this->getPostsFilteredPaginated->setSearch($this->input->search);
        $this->getPostsFilteredPaginated->setStatus($this->input->status);
        $this->getPostsFilteredPaginated->setCategoryId($this->input->categoryId);
        $this->getPostsFilteredPaginated->setUserId($this->input->userId);
        $this->getPostsFilteredPaginated->setOrderField($this->input->orderField);
        $this->getPostsFilteredPaginated->setOrderDirection($this->input->orderDirection);
        $this->getPostsFilteredPaginated->setLimit(self::POSTS_PER_PAGE);
        $this->getPostsFilteredPaginated->setPage($this->input->page);
        $posts = $this->getPostsFilteredPaginated->run();

        $this->countPostsFiltered->setSearch($this->input->search);
        $this->countPostsFiltered->setStatus($this->input->status);
        $this->countPostsFiltered->setCategoryId($this->input->categoryId);
        $this->countPostsFiltered->setUserId($this->input->userId);
        $totalPosts = $this->countPostsFiltered->run();

        $this->countPostsFiltered->setStatus(Post::STATUS_DRAFT);
        $draftPostsNumber = $this->countPostsFiltered->run();

        $this->countPostsFiltered->setStatus(Post::STATUS_PUBLISHED);
        $publishedPostsNumber = $this->countPostsFiltered->run();

        $this->countPostsFiltered->setStatus(Post::STATUS_TRASH);
        $trashPostsNumber = $this->countPostsFiltered->run();

        $this->getUsersByRole->setRoles([User::ROLE_EDITOR, User::ROLE_ADMIN]);
        $roles = $this->getUsersByRole->run();

        $categories = $this->getCategoriesWithPostCount->run();

        $filters = [
            [
                'name' => Post::STATUS_PUBLISHED_NAME,
                'slug' => Post::STATUS_PUBLISHED,
                'count' => $publishedPostsNumber
            ],
            [
                'name' => Post::STATUS_DRAFT_NAME,
                'slug' => Post::STATUS_DRAFT,
                'count' => $draftPostsNumber
            ],
            [
                'name' => Post::STATUS_TRASH_NAME,
                'slug' => Post::STATUS_TRASH,
                'count' => $trashPostsNumber
            ]
        ];

        $this->output->setStatusFilters($filters);
        $this->output->setCategories($categories);
        $this->output->setWriters($roles);
        $this->output->setPosts($posts);
        $this->output->setTotalPostsNumber($totalPosts);
        $this->output->setBaseUrl(self::BASE_URL);
        $this->output->setPage($this->input->page);
        $this->output->setPagination($this->getPagination($totalPosts, $this->input->page));
        $this->output->setPaginationParameters($this->getQueryParams());

        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }

    private function getQueryParams()
    {
        $queryParams = [
            Input::PARAM_ORDER_FIELD => $this->input->orderField,
            Input::PARAM_ORDER_DIRECTION => $this->input->orderDirection
        ];

        if (!is_null($this->input->search)) {
            $queryParams[Input::PARAM_SEARCH] = $this->input->search;
        }

        if (!is_null($this->input->status)) {
            $queryParams[Input::PARAM_STATUS] = $this->input->status;
        }

        if (!is_null($this->input->userId)) {
            $queryParams[Input::PARAM_AUTHOR] = $this->input->userId;
        }

        if (!is_null($this->input->categoryId)) {
            $queryParams[Input::PARAM_TYPE] = $this->input->categoryId;
        }

        return $queryParams;
    }

    private function getPagination($total, $page)
    {
        return $this->pagination->setup(
            $total,
            self::POSTS_PER_PAGE,
            $page
        );
    }
}
