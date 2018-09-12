<?php
namespace Http\Actions\Dashboard;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;

class DashboardResponder extends Responder
{
    public function success(Response $response, $data) {
        return $this->view->render(
            $response,
            "routes/dashboard.twig",
            $data
        );
    }
}
