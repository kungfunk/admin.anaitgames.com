<?php
namespace Domain\User\Commands;

use App\Commands\CommandInterface;
use Domain\User\UsersRepository;

class GetUsersByRole implements CommandInterface
{
    private $usersRepository;
    private $roles;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function run()
    {
        return $this->usersRepository->getUserByRoles($this->roles);
    }
}
