<?php
namespace Http\Actions\GetComments;

use Http\Actions\Responder as Responder;

class GetCommentsResponder extends Responder
{
    public const TEMPLATE = 'routes/comments.twig';
}
