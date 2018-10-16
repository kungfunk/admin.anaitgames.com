<?php
namespace Http\Actions\GetBans;

use Http\Actions\Responder as Responder;

class GetBansResponder extends Responder
{
    public const TEMPLATE = 'routes/bans.twig';
}
