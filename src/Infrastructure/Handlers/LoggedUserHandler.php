<?php
namespace Infrastructure\Handlers;

class LoggedUserHandler
{
    private $user;
    private $isAuth = false;

    public function set($user)
    {
        $this->user = $user;
        $this->isAuth = true;
    }

    public function get()
    {
        return $this->user;
    }

    public function isAuth()
    {
        return $this->isAuth;
    }
}
