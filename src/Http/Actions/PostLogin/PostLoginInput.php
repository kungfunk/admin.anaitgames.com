<?php
namespace Http\Actions\PostLogin;

use Http\Actions\Input;
use Infrastructure\Exceptions\BadInputException;
use Respect\Validation\Validator;

class PostLoginInput extends Input
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function validate()
    {
        if (!$this->validateUsername($this->username) || !$this->validatePassword($this->password)) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }

    public function validateUsername($username)
    {
        return Validator::alnum()->noWhitespace()->notEmpty()->validate($username);
    }

    public function validatePassword($password)
    {
        return Validator::notEmpty()->validate($password);
    }
}
