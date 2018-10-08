<?php
namespace Http\Actions\GetUsers;

use Http\Actions\Responder as Responder;

class GetUsersResponder extends Responder
{
    public const TEMPLATE = 'routes/users.twig';
}
