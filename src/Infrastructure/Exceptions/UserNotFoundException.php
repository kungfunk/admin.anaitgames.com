<?php
namespace Infrastructure\Exceptions;

class UserNotFoundException extends \Exception
{
    const USER_NOT_FOUND = 'This user does not exists';
}
