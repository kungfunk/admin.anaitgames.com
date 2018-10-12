<?php
namespace Http\Actions\GetLogs;

use Http\Actions\Action;
use Models\Log;

use Slim\Http\Request;
use Slim\Http\Response;
use Http\Actions\GetLogs\GetLogsInput as Input;
use Http\Actions\GetLogs\GetLogsResponder as Responder;

class GetLogsAction extends Action
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

        $this->output['logs'] = Log::filters([
            'user_id' => $this->input->user_id,
            'level' => $this->input->post_id
        ])
            ->with('user')
            ->orderBy(...$this->input->getOrderFields())
            ->paginate(self::ITEMS_PER_PAGE)
            ->withPath($this->router->pathFor('logs'))
            ->appends($this->input->getFilledData());

        $this->output['levelFilters'] = [
            $this->getLevelFilter(Log::LEVEL_INFO),
            $this->getLevelFilter(Log::LEVEL_NOTICE),
            $this->getLevelFilter(Log::LEVEL_WARNING),
            $this->getLevelFilter(Log::LEVEL_ERROR),
        ];

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }

    private function getLevelFilter($filterSlug)
    {
        return [
            'name' => $filterSlug,
            'slug' => $filterSlug,
            'count' => Log::whereLevel($filterSlug)->count()
        ];
    }
}
