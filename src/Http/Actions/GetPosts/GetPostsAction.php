<?php
namespace Http\Actions\GetPosts;

use Domain\User\User;
use Domain\Post\Post;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Domain\Post\Commands\CountPostsFiltered;
use Domain\Post\Commands\GetPostsFilteredPaginated;
use Domain\Post\Commands\GetCategoriesWithPostCount;
use Domain\User\Commands\GetUsersByRole;

class GetPostsAction
{
    private $responder;
    private $input;
    private $countPostsFiltered;
    private $getPostsFilteredPaginated;
    private $getCategoriesWithPostCount;
    private $getUsersByRole;

    public function __construct(
        GetPostsResponder $responder,
        CountPostsFiltered $countPostsFiltered,
        GetPostsFilteredPaginated $getPostsFilteredPaginated,
        GetCategoriesWithPostCount $getCategoriesWithPostCount,
        GetUsersByRole $getUsersByRole
    ) {
        $this->responder = $responder;
        $this->countPostsFiltered = $countPostsFiltered;
        $this->getPostsFilteredPaginated = $getPostsFilteredPaginated;
        $this->getCategoriesWithPostCount = $getCategoriesWithPostCount;
        $this->getUsersByRole = $getUsersByRole;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->input = new Input($request);

        $this->responder->setPaginationParameters($this->input);

        $this->getPostsFilteredPaginated->setSearch($this->input->search);
        $this->getPostsFilteredPaginated->setStatus($this->input->status);
        $this->getPostsFilteredPaginated->setCategoryId($this->input->categoryId);
        $this->getPostsFilteredPaginated->setUserId($this->input->userId);
        $this->getPostsFilteredPaginated->setOrderField($this->input->orderField);
        $this->getPostsFilteredPaginated->setOrderDirection($this->input->orderDirection);
        $this->getPostsFilteredPaginated->setLimit($this->responder::POSTS_PER_PAGE);
        $this->getPostsFilteredPaginated->setPage($this->input->page);
        $this->responder->setPosts($this->getPostsFilteredPaginated->run());

        $this->countPostsFiltered->setSearch($this->input->search);
        $this->countPostsFiltered->setStatus($this->input->status);
        $this->countPostsFiltered->setCategoryId($this->input->categoryId);
        $this->countPostsFiltered->setUserId($this->input->userId);
        $this->responder->setTotalPostsNumber($this->countPostsFiltered->run());

        $this->countPostsFiltered->setStatus(Post::STATUS_DRAFT);
        $draftPostsNumber = $this->countPostsFiltered->run();

        $this->countPostsFiltered->setStatus(Post::STATUS_PUBLISHED);
        $publishedPostsNumber = $this->countPostsFiltered->run();

        $this->countPostsFiltered->setStatus(Post::STATUS_TRASH);
        $trashPostsNumber = $this->countPostsFiltered->run();

        $this->responder->setStatusFilters([
            [ 'name' => Post::STATUS_PUBLISHED_NAME, 'slug' => Post::STATUS_PUBLISHED, 'count' => $publishedPostsNumber ],
            [ 'name' => Post::STATUS_DRAFT_NAME, 'slug' => Post::STATUS_DRAFT, 'count' => $draftPostsNumber ],
            [ 'name' => Post::STATUS_TRASH_NAME, 'slug' => Post::STATUS_TRASH, 'count' => $trashPostsNumber ],
        ]);

        $this->responder->setCategories($this->getCategoriesWithPostCount->run());
        $this->getUsersByRole->setRoles([User::ROLE_EDITOR, User::ROLE_ADMIN]);
        $this->responder->setWriters($this->getUsersByRole->run());

        $this->responder->setPage($this->input->page);
        $this->responder->setPostsPagination();

        return $this->responder->toHtml($response);
    }
}
