<?php
namespace Http\Actions\GetComments;

use Http\Actions\Action;
use Http\Helpers\Pagination;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
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

        $filterParams  = [
            $this->input->search,
            $this->input->user_id,
            $this->input->post_id
        ];

        $orderAndPaginationParams = [
            $this->input->order_field,
            $this->input->order_direction,
            self::ITEMS_PER_PAGE,
            self::ITEMS_PER_PAGE * ($this->input->page - 1)
        ];

        $this->output['comments'] = $this->commentsRepository
            ->setFilters(...$filterParams)
            ->setOrderAndPagination(...$orderAndPaginationParams)
            ->addRelationShips()
            ->get();

        $this->output['pagination'] = new Pagination(
            $this->commentsRepository->setFilters(...$filterParams)->count(),
            self::ITEMS_PER_PAGE,
            $this->input->page
        );

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
