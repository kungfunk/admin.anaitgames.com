<?php
namespace Infrastructure\Exceptions;

class InvalidCredentialException extends \Exception
{
    const INCORRECT_PASSWORD = 'The password is incorrect';
}
