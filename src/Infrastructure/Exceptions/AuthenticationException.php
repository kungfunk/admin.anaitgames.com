<?php
namespace Infrastructure\Exceptions;

class AuthenticationException extends \Exception
{
    const USER_IS_BANNED = 'This user is banned from this domain';
    const NOT_ENOUGH_PERMISSIONS = 'No enough permissions to access the resource';
    const INVALID_CREDENTIALS = 'Wrong username or password';
}
