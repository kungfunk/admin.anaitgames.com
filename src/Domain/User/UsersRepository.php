<?php
namespace Domain\User;

use Carbon\Carbon;

class UsersRepository
{
    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function getUserById(int $id): User
    {
        return $this->userModel->find($id);
    }

    public function getUsersPaginated(
        string $orderField = User::DEFAULT_ORDER_FIELD,
        string $orderDirection = User::DEFAULT_ORDER_DIRECTION,
        int $limit = User::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        return $this->userModel
            ->orderBy($orderField, $orderDirection)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function countUsersFromDate(Carbon $startDate, Carbon $endDate)
    {
        return $this->userModel
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
