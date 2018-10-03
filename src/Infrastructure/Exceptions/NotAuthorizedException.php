<?php
namespace Infrastructure\Exceptions;

class NotAuthorizedException extends \Exception
{
    const USER_IS_NOT_LOGGED_IN = 'You must login first';
    const USER_IS_LOGGED_IN = 'You must logoff first';
}
