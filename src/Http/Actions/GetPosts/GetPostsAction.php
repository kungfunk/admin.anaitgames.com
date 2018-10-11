<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Http\Actions\GetPosts\GetPostsResponder as Responder;

use Domain\Post\Post;

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

        $this->output['writers'] = $this->usersRepository->getWriters();
        $this->output['categories'] = $this->categoriesRepository->addRelationShips()->get();
        $this->output['statusFilters'] = [
            [
                'name' => Post::STATUS_PUBLISHED_NAME,
                'slug' => Post::STATUS_PUBLISHED,
                'count' => Post::filters([
                    'category_id' => $this->input->category_id,
                    'user_id' => $this->input->user_id,
                    'status' => Post::STATUS_PUBLISHED
                ])->count()
            ],
            [
                'name' => Post::STATUS_DRAFT_NAME,
                'slug' => Post::STATUS_DRAFT,
                'count' => Post::filters([
                    'category_id' => $this->input->category_id,
                    'user_id' => $this->input->user_id,
                    'status' => Post::STATUS_DRAFT
                ])->count()
            ],
            [
                'name' => Post::STATUS_TRASH_NAME,
                'slug' => Post::STATUS_TRASH,
                'count' => Post::filters([
                    'category_id' => $this->input->category_id,
                    'user_id' => $this->input->user_id,
                    'status' => Post::STATUS_TRASH
                ])->count()
            ]
        ];

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
