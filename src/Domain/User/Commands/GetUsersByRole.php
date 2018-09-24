<?php
namespace Domain\User\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\User\UsersRepository;

class GetUsersByRole implements CommandInterface
{
    private $usersRepository;
    private $roles;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository;
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
