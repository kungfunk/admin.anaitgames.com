<?php
namespace Http\Actions\GetPosts;

use Domain\User\User;
use Domain\Post\Post;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Domain\Post\Commands\CountTotalPosts;
use Domain\Post\Commands\GetPostsFilteredPaginated;
use Domain\Post\Commands\GetCategoriesWithPostCount;
use Domain\Post\Commands\CountPostsByStatus;
use Domain\User\Commands\GetUsersByRole;

class GetPostsAction
{
    private $responder;
    private $input;
    private $countTotalPosts;
    private $getPostsFilteredPaginated;
    private $getCategoriesWithPostCount;
    private $countPostsByStatus;
    private $getUsersByRole;

    public function __construct(
        GetPostsResponder $responder,
        CountTotalPosts $countTotalPosts,
        GetPostsFilteredPaginated $getPostsFilteredPaginated,
        GetCategoriesWithPostCount $getCategoriesWithPostCount,
        CountPostsByStatus $countPostsByStatus,
        GetUsersByRole $getUsersByRole
    ) {
        $this->responder = $responder;
        $this->countTotalPosts = $countTotalPosts;
        $this->getPostsFilteredPaginated = $getPostsFilteredPaginated;
        $this->getCategoriesWithPostCount = $getCategoriesWithPostCount;
        $this->countPostsByStatus = $countPostsByStatus;
        $this->getUsersByRole = $getUsersByRole;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->input = new Input($request);

        $this->getPostsFilteredPaginated->setSearch($this->input->search);
        $this->getPostsFilteredPaginated->setStatus($this->input->status);
        $this->getPostsFilteredPaginated->setCategoryId($this->input->categoryId);
        $this->getPostsFilteredPaginated->setOrderField($this->input->orderField);
        $this->getPostsFilteredPaginated->setOrderDirection($this->input->orderDirection);
        $this->getPostsFilteredPaginated->setOffset($this->input->offset);
        $this->responder->setPosts($this->getPostsFilteredPaginated->run());

        $this->countPostsByStatus->setStatus(Post::STATUS_DRAFT);
        $this->responder->setDraftPostsNumber($this->countPostsByStatus->run());

        $this->countPostsByStatus->setStatus(Post::STATUS_PUBLISHED);
        $this->responder->setPublishedPostsNumber($this->countPostsByStatus->run());

        $this->countPostsByStatus->setStatus(Post::STATUS_TRASH);
        $this->responder->setTrashPostsNumber($this->countPostsByStatus->run());

        $this->responder->setCategories($this->getCategoriesWithPostCount->run());
        $this->responder->setTotalPostsNumber($this->countTotalPosts->run());

        $this->getUsersByRole->setRoles([User::ROLE_EDITOR, User::ROLE_ADMIN]);
        $this->responder->setWriters($this->getUsersByRole->run());

        return $this->responder->success($response);
    }
}
