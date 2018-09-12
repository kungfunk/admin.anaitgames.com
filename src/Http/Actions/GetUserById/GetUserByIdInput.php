<?php
namespace Http\Actions\GetUserById;

use Http\Actions\Input;
use Psr\Http\Message\ServerRequestInterface as Request;
use Http\Actions\BadInputException as BadInputException;
use Domain\User\User as User;

class GetUserByIdInput extends Input
{
    public $id;

    public function __construct(Request $request) {
        $this->id = (int) $request->getAttribute(User::ID);

        if($this->id < $this::MINIMUM_ID) {
            throw new BadInputException(BadInputException::IDENTIFIER_MALFORMED);
        }
    }
}