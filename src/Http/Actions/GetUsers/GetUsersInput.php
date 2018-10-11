<?php
namespace Http\Actions\GetUsers;

use Http\Actions\Input;
use Infrastructure\Exceptions\BadInputException;
use Domain\User\User;

class GetUsersInput extends Input
{
    const ROLE_WHITELIST = [
        User::ROLE_SUPERADMIN,
        User::ROLE_ADMIN,
        User::ROLE_EDITOR,
        User::ROLE_MODERATOR,
        User::ROLE_USER
    ];

    const PATREON_LEVEL_WHITELIST = [
        User::PATREON_BRONZE_LEVEL,
        User::PATREON_SILVER_LEVEL,
        User::PATREON_GOLD_LEVEL
    ];

    protected $defaults = [
        'role' => null,
        'patreon_level' => null,
        self::PARAM_PAGE => 1,
        self::PARAM_SEARCH => null,
        self::PARAM_ORDER_FIELD => User::DEFAULT_ORDER_FIELD,
        self::PARAM_ORDER_DIRECTION => self::DEFAULT_ORDER_DIRECTION,
    ];

    public function validate()
    {
        $this->isValidRole($this->role);
        $this->isValidPatreonLevel($this->patreon_level);
        $this->isValidOrder($this->order_direction, $this->order_field);
    }

    private function isValidRole($role)
    {
        if ($role && !in_array($role, $this::ROLE_WHITELIST)) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }

    private function isValidPatreonLevel($patreonLevel)
    {
        if ($patreonLevel && !in_array($patreonLevel, $this::PATREON_LEVEL_WHITELIST)) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }

    private function isValidOrder($orderDirection, $orderField)
    {
        if (!in_array($orderField, User::ORDER_FIELD_WHITELIST) ||
            !in_array($orderDirection, $this::ORDER_DIRECTION_WHITELIST)
        ) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }
}
