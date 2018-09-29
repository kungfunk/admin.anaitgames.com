<?php
namespace Infrastructure\Exceptions;

class UserLogonException extends \Exception
{
    const USER_NOT_FOUND = 'This user does not exists';
    const INCORRECT_PASSWORD = 'The password is incorrect';
    const USER_IS_BANNED = 'This user is banned and cannot access';
}
