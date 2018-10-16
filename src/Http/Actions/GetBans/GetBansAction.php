<?php
namespace Http\Actions\GetBans;

use Http\Actions\Action;
use Models\Ban;

use Slim\Http\Request;
use Slim\Http\Response;
use Http\Actions\GetBans\GetBansInput as Input;
use Http\Actions\GetBans\GetBansResponder as Responder;

class GetBansAction extends Action
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

        $this->output['bans'] = Ban::filters([
            'user_id' => $this->input->user_id
        ])
            ->with(['user', 'bannedBy'])
            ->orderBy(...$this->input->getOrderFields())
            ->paginate(self::ITEMS_PER_PAGE)
            ->withPath($this->router->pathFor('bans'))
            ->appends($this->input->getFilledData());

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
