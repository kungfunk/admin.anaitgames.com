<?php
namespace Http\Actions\GetUsers;

use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\Responder as Responder;

class GetUsersResponder extends Responder
{
    public function success(Response $response, $data) {
        return $response
            ->withStatus($this::HTTP_STATUS_CODE_OK)
            ->withHeader("Content-Type", "application/json")
            ->withJson([
                'status' => $this::STATUS_SUCCESS,
                'data' => $data,
            ]);
    }
}