<?php
namespace Infrastructure\Exceptions;

class NotEnoughPermissionsException extends \Exception
{
    const NOT_ENOUGH_PERMISSIONS = 'You must be admin or editor to access';
}
