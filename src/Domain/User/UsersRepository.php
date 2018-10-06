<?php
namespace Domain\User;

use Carbon\Carbon;
use Domain\Repository;

class UsersRepository extends Repository
{
    public function __construct()
    {
        $this->model = new User;
        parent::__construct();
    }

    public function getUserById(int $id)
    {
        return $this->model->find($id);
    }

    public function getUserByUsername(string $username)
    {
        return $this->model->where('username', $username)->first();
    }

    public function getUserByRoles($roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        return $this->model
            ->withCount('posts')
            ->whereIn('role', $roles)
            ->get();
    }


    public function getUsersPaginated(
        string $orderField = User::DEFAULT_ORDER_FIELD,
        string $orderDirection = User::DEFAULT_ORDER_DIRECTION,
        int $limit = User::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        return $this->model
            ->orderBy($orderField, $orderDirection)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function countUsersFromDate(Carbon $startDate, Carbon $endDate)
    {
        return $this->model
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
