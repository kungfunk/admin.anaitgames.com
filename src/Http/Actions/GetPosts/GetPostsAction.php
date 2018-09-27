<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Action;
use Http\Helpers\Pagination;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Http\Actions\GetPosts\GetPostsOutput as Output;
use Http\Actions\GetPosts\GetPostsResponder as Responder;

use Domain\User\User;
use Domain\Post\Post;

class GetPostsAction extends Action
{
    public const POSTS_PER_PAGE = 20;

    private $responder;
    private $input;
    private $output;
    private $pagination;

    public function __invoke(Request $request, Response $response)
    {
        $this->output = new Output;
        $this->pagination = new Pagination;

        $data = $request->getQueryParams();
        $this->input = new Input($data);

        $this->getPostsFilteredPaginated->setSearch($this->input->search);
        $this->getPostsFilteredPaginated->setStatus($this->input->status);
        $this->getPostsFilteredPaginated->setUserId($this->input->user_id);
        $this->getPostsFilteredPaginated->setOrderField($this->input->order_field);
        $this->getPostsFilteredPaginated->setOrderDirection($this->input->order_direction);
        $this->getPostsFilteredPaginated->setLimit(self::POSTS_PER_PAGE);
        $this->getPostsFilteredPaginated->setPage($this->input->page);
        $posts = $this->getPostsFilteredPaginated->run();

        $this->countPostsFiltered->setSearch($this->input->search);
        $this->countPostsFiltered->setStatus($this->input->status);
        $this->countPostsFiltered->setCategoryId($this->input->category_id);
        $this->countPostsFiltered->setUserId($this->input->user_id);
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
        $this->output->setPage($this->input->page);
        $this->output->setPagination($this->getPagination($totalPosts, $this->input->page));

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
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
