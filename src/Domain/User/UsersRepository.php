<?php
namespace Domain\User;

use Carbon\Carbon;

class UsersRepository
{
    private $user_model;

    public function __construct(User $user)
    {
        $this->user_model = $user;
    }

    public function getUserById(int $id): User
    {
        return $this->user_model->find($id);
    }

    public function getUsersPaginated(
        string $order_field = User::DEFAULT_ORDER_FIELD,
        string $order_direction = User::DEFAULT_ORDER_DIRECTION,
        int $limit = User::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        return $this->user_model
            ->orderBy($order_field, $order_direction)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function countUsersFromDate(Carbon $startDate, Carbon $endDate)
    {
        return $this->user_model
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
