<?php
namespace Http\Actions\Dashboard;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;
use Slim\Views\Twig;

class DashboardResponder extends Responder
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function success(Response $response, $data)
    {
        return $this->twig->render(
            $response,
            "routes/dashboard.twig",
            $data
        );
    }
}
