<?php
namespace Infrastructure\Exceptions;

class AuthenticationException extends \Exception
{
    const USER_IS_BANNED = 'This user is banned from this domain';
    const NOT_ENOUGH_PERMISSIONS = 'No enough permissions to access the resource';
    const INVALID_CREDENTIALS = 'Wrong username or password';
    const REMEMBER_TOKEN_MISMATCH = 'The session token is not correct';
    const LOGIN_NEEDED = 'You need to be logged to access this resource';
}
