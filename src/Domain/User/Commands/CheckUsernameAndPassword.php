<?php
namespace Domain\User\Commands;

use Infrastructure\Interfaces\CommandInterface;
use Domain\User\UsersRepository;
use Domain\User\Exceptions\UserNotFoundException;

class CheckUsernameAndPassword implements CommandInterface
{
    protected $repository;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->repository = new UsersRepository;
    }

    public function setup($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }

    public function run()
    {
        $user = $this->repository->getUserByUsername($this->username);
        if (!$user) {
            throw new UserNotFoundException(UserNotFoundException::NOT_FOUND);
        }
        return password_verify($user->password, $this->password);
    }
}
