<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Responder as Responder;

class GetPostsResponder extends Responder
{
    public const TEMPLATE = 'routes/posts.twig';
}
