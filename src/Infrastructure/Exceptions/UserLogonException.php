<?php
namespace Infrastructure\Exceptions;

class UserLogonException extends \Exception
{
    const INCORRECT_PASSWORD = 'The password is incorrect';
}
