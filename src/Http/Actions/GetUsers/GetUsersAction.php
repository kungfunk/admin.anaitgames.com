<?php
namespace Http\Actions\GetUsers;

use Http\Actions\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Http\Actions\GetUsers\GetUsersInput as Input;
use Http\Actions\GetUsers\GetUsersResponder as Responder;

use Models\User;

class GetUsersAction extends Action
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

        $this->output['users'] = User::filters([
            'role' => $this->input->role,
            'patreon_level' => $this->input->patreon_level
        ])
            ->search($this->input->search)
            ->orderBy(...$this->input->getOrderFields())
            ->paginate(self::ITEMS_PER_PAGE)
            ->withPath($this->router->pathFor('users'))
            ->appends($this->input->getFilledData());

        $this->output['roleFilters'] = [
            $this->getRoleFilter(User::ROLE_USER_NAME, User::ROLE_USER),
            $this->getRoleFilter(User::ROLE_MODERATOR_NAME, User::ROLE_MODERATOR),
            $this->getRoleFilter(User::ROLE_EDITOR_NAME, User::ROLE_EDITOR),
            $this->getRoleFilter(User::ROLE_ADMIN_NAME, User::ROLE_ADMIN),
            $this->getRoleFilter(User::ROLE_SUPERADMIN_NAME, User::ROLE_SUPERADMIN)
        ];

        $this->output['patreonFilters'] = [
            $this->getPatreonLevelFilter(User::PATREON_BRONZE_LEVEL_NAME, User::PATREON_BRONZE_LEVEL),
            $this->getPatreonLevelFilter(User::PATREON_SILVER_LEVEL_NAME, User::PATREON_SILVER_LEVEL),
            $this->getPatreonLevelFilter(User::PATREON_GOLD_LEVEL_NAME, User::PATREON_GOLD_LEVEL),
        ];

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }

    private function getRoleFilter($filterName, $filterSlug)
    {
        return [
            'name' => $filterName,
            'slug' => $filterSlug,
            'count' => User::filters([
                'role' => $filterSlug,
                'patreon_level' => $this->input->patreon_level
            ])->count()
        ];
    }

    private function getPatreonLevelFilter($filterName, $filterSlug)
    {
        return [
            'name' => $filterName,
            'slug' => $filterSlug,
            'count' => User::filters([
                'role' => $this->input->role,
                'patreon_level' => $filterSlug
            ])->count()
        ];
    }
}
