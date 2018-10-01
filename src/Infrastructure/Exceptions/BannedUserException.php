<?php
namespace Infrastructure\Exceptions;

class BannedUserException extends \Exception
{
    const USER_IS_BANNED = 'This user does not exists';
}
