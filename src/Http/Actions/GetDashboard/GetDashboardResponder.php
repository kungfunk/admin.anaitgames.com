<?php
namespace Http\Actions\GetDashboard;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;

use Slim\Views\Twig;
use Illuminate\Database\Eloquent\Collection;

class GetDashboardResponder extends Responder
{
    private $twig;
    private $data;

    private const DASHBOARD_TEMPLATE_ROUTE = 'routes/dashboard.twig';

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
        $this->data = [];
    }

    public function setLastFiveRegisteredUsers(Collection $users)
    {
        $this->data['last_users'] = $users;
    }

    public function success(Response $response)
    {
        return $this->twig->render(
            $response,
            self::DASHBOARD_TEMPLATE_ROUTE,
            $this->data
        );
    }
}
