<?php
namespace Infrastructure\Handlers;

use Models\User;

class LoggedUserHandler
{
    private $user;
    private $isAuth = false;

    public function set(User $user)
    {
        $this->user = $user;
        $this->isAuth = true;
    }

    public function get(): User
    {
        return $this->user;
    }

    public function isAuth(): bool
    {
        return $this->isAuth;
    }
}
