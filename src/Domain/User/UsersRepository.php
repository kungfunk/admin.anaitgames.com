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

    public function setOrderAndPagination(
        string $orderField = User::DEFAULT_ORDER_FIELD,
        string $orderDirection = User::DEFAULT_ORDER_DIRECTION,
        int $limit = User::DEFAULT_LIMIT,
        int $offset = 0
    ) {
        $this->query
            ->orderBy($orderField, $orderDirection)
            ->offset($offset)
            ->limit($limit);

        return $this;
    }

    public function setFilters(
        string $search = null,
        string $role = null,
        int $patreon_level = null
    ) {
        if (!is_null($search)) {
            $this->setSearch($search);
        }

        if (!is_null($role)) {
            $this->setRole($role);
        }

        if (!is_null($patreon_level)) {
            $this->setPatreonLevel($patreon_level);
        }

        return $this;
    }

    public function setSearch($search)
    {
        $this->query->where(
            'name',
            'like',
            '%' . $search . '%'
        )->orWhere(
            'username',
            'like',
            '%' . $search . '%'
        );

        return $this;
    }

    public function setRole($role)
    {
        $this->query->where('role', $role);
        return $this;
    }

    public function setPatreonLevel($patreonLevel)
    {
        $this->query->where('patreon_level', $patreonLevel);
        return $this;
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
