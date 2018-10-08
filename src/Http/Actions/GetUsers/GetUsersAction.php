<?php
namespace Http\Actions\GetUsers;

use Http\Actions\Action;
use Http\Helpers\Pagination;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetUsers\GetUsersInput as Input;
use Http\Actions\GetUsers\GetUsersResponder as Responder;

use Domain\User\User;

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

        $filterParams  = [
            $this->input->search,
            $this->input->role,
            $this->input->patreon_level
        ];

        $orderAndPaginationParams = [
            $this->input->order_field,
            $this->input->order_direction,
            self::ITEMS_PER_PAGE,
            self::ITEMS_PER_PAGE * ($this->input->page - 1)
        ];

        $this->output['users'] = $this->usersRepository
            ->setFilters(...$filterParams)
            ->setOrderAndPagination(...$orderAndPaginationParams)
            ->get();

        $this->output['roleFilters'] = [
            [
                'name' => User::ROLE_USER_NAME,
                'slug' => User::ROLE_USER,
                'count' => $this->usersRepository->setRole(User::ROLE_USER)->count()
            ],
            [
                'name' => User::ROLE_MODERATOR_NAME,
                'slug' => User::ROLE_MODERATOR,
                'count' => $this->usersRepository->setRole(User::ROLE_MODERATOR)->count()
            ],
            [
                'name' => User::ROLE_EDITOR_NAME,
                'slug' => User::ROLE_EDITOR,
                'count' => $this->usersRepository->setRole(User::ROLE_EDITOR)->count()
            ],
            [
                'name' => User::ROLE_ADMIN_NAME,
                'slug' => User::ROLE_ADMIN,
                'count' => $this->usersRepository->setRole(User::ROLE_ADMIN)->count()
            ],
            [
                'name' => User::ROLE_SUPERADMIN_NAME,
                'slug' => User::ROLE_SUPERADMIN,
                'count' => $this->usersRepository->setRole(User::ROLE_SUPERADMIN)->count()
            ]
        ];

        $this->output['patreonFilters'] = [
            [
                'name' => User::PATREON_BRONZE_LEVEL_NAME,
                'slug' => User::PATREON_BRONZE_LEVEL,
                'count' => $this->usersRepository->setPatreonLevel(User::PATREON_BRONZE_LEVEL)->count()
            ],
            [
                'name' => User::PATREON_SILVER_LEVEL_NAME,
                'slug' => User::PATREON_SILVER_LEVEL,
                'count' => $this->usersRepository->setPatreonLevel(User::PATREON_SILVER_LEVEL)->count()
            ],
            [
                'name' => User::PATREON_GOLD_LEVEL_NAME,
                'slug' => User::PATREON_GOLD_LEVEL,
                'count' => $this->usersRepository->setPatreonLevel(User::PATREON_GOLD_LEVEL)->count()
            ]
        ];

        $this->output['pagination'] = new Pagination(
            $this->usersRepository->setFilters(...$filterParams)->count(),
            self::ITEMS_PER_PAGE,
            $this->input->page
        );

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
