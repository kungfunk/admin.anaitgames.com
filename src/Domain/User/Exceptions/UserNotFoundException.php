<?php
namespace Domain\User\Exceptions;

class UserNotFoundException extends \Exception
{
    const NOT_FOUND = 'User not found in database';
}
