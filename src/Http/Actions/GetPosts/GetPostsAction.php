<?php
namespace Http\Actions\GetPosts;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Domain\Post\Commands\CountTotalPosts;
use Domain\Post\Commands\GetPostsFilteredPaginated;
use Domain\Post\CategoriesRepository;

class GetPostsAction
{
    private $responder;
    private $input;
    private $countTotalPosts;
    private $getPostsFilteredPaginated;
    private $categoriesRepository;

    public function __construct(
        GetPostsResponder $responder,
        CategoriesRepository $categoriesRepository,
        CountTotalPosts $countTotalPosts,
        GetPostsFilteredPaginated $getPostsFilteredPaginated
    ) {
        $this->responder = $responder;
        $this->categoriesRepository = $categoriesRepository;
        $this->countTotalPosts = $countTotalPosts;
        $this->getPostsFilteredPaginated = $getPostsFilteredPaginated;
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

        $this->responder->setCategories($this->categoriesRepository->getAllWithPostCount());
        $this->responder->setPosts($this->getPostsFilteredPaginated->run());
        $this->responder->setTotalPostsNumber($this->countTotalPosts->run());

        return $this->responder->success($response);
    }
}
