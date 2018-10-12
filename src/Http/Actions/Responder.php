<?php
namespace Http\Actions;

use Slim\Http\Response;

use Slim\Views\Twig;

class Responder
{
    public const HTTP_STATUS_CODE_OK = 200;
    public const HTTP_STATUS_CODE_CREATED = 201;
    public const HTTP_STATUS_CODE_NOT_FOUND = 404;

    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';

    public const TEMPLATE = '';

    private $twig;
    private $response;
    private $output = [];
    private $template;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function setTemplate(string $template)
    {
        $this->template = $template;
    }

    public function setOutput($output)
    {
        $this->output = (array) $output;
    }

    public function toHtml()
    {
        return $this->twig->render(
            $this->response,
            static::TEMPLATE,
            $this->output
        );
    }

    public function toJson()
    {
        return $this->response
            ->withStatus($this::HTTP_STATUS_CODE_OK)
            ->withHeader("Content-Type", "application/json")
            ->withJson([
                'status' => $this::STATUS_SUCCESS,
                'data' => $this->output,
            ]);
    }
}
