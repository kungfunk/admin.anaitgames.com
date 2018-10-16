<?php
namespace Http\Actions\GetComments;

use Http\Actions\Action;
use Models\Comment;

use Slim\Http\Request;
use Slim\Http\Response;
use Http\Actions\GetComments\GetCommentsInput as Input;
use Http\Actions\GetComments\GetCommentsResponder as Responder;

class GetCommentsAction extends Action
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

        $this->output['comments'] = Comment::filters([
            'user_id' => $this->input->user_id,
            'post_id' => $this->input->post_id
        ])
            ->search($this->input->search)
            ->withCount('reports')
            ->with(['user', 'post'])
            ->orderBy(...$this->input->getOrderFields())
            ->paginate(self::ITEMS_PER_PAGE)
            ->withPath($this->router->pathFor('comments'))
            ->appends($this->input->getFilledData());

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
