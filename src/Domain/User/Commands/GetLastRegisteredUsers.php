<?php
namespace Domain\User\Commands;

use App\Commands\CommandInterface;
use Domain\User\UsersRepository;
use Domain\User\User;

class GetLastRegisteredUsers implements CommandInterface
{
    private $repository;
    private static $order_field = User::DEFAULT_ORDER_FIELD;
    private static $order_direction = User::DEFAULT_ORDER_DIRECTION;
    private static $limit = 10;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->repository->getUsersPaginated(
            self::$order_field,
            self::$order_direction,
            self::$limit
        );
    }
}
