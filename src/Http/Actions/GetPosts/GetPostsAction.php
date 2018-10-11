<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Http\Actions\GetPosts\GetPostsResponder as Responder;

use Domain\Post\Post;
use Domain\Post\Category;
use Domain\User\User;

class GetPostsAction extends Action
{
    public const ITEMS_PER_PAGE = 20;

    private $responder;
    private $input;
    private $output = [];

    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getQueryParams();
        $this->input = new Input($data);
        $this->input->validate();

        $this->output['posts'] = Post::filters([
            'category_id' => $this->input->category_id,
            'user_id' => $this->input->user_id,
            'status' => $this->input->status
        ])
            ->search($this->input->search)
            ->withCount('comments')
            ->with('category')
            ->with('user')
            ->with('tags')
            ->orderBy(...$this->input->getOrderFields())
            ->paginate(self::ITEMS_PER_PAGE)
            ->withPath($this->router->pathFor('posts'))
            ->appends($this->input->getFilledData());

        $this->output['writers'] = User::writers()->withCount('posts')->get();
        $this->output['categories'] = Category::withCount('posts')->get();
        $this->output['statusFilters'] = [
            $this->getStatusFilter(Post::STATUS_PUBLISHED_NAME, Post::STATUS_PUBLISHED),
            $this->getStatusFilter(Post::STATUS_DRAFT_NAME, Post::STATUS_DRAFT),
            $this->getStatusFilter(Post::STATUS_TRASH_NAME, Post::STATUS_TRASH)
        ];

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }

    private function getStatusFilter($filterName, $filterSlug)
    {
        return [
            'name' => $filterName,
            'slug' => $filterSlug,
            'count' => Post::filters([
                'category_id' => $this->input->category_id,
                'user_id' => $this->input->user_id,
                'status' => $filterSlug
            ])->count()
        ];
    }
}
